<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use DB;

class Court extends Model
{
    protected $visible = ['name'];

    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function getNameAttribute()
    {
        if ($this->def != '0' or !isset($this->def)) {
            $key = 'name_' . $this->def;
        } else {
            $input = ['name_fr', 'name_nl', 'name_de'];
            $rand_keys = array_rand($input);
            $key = $input[$rand_keys];
        }

        return $this->$key;
    }

    public function getDocsPerLangAttribute()
    {
        return Cache::rememberForever('docs_per_lang' . $this->id, function () {
            $docs_per_lang = $this->hasMany('App\Models\Document')
        ->select(DB::raw('count(*) as documents_count, lang'))
        ->groupBy('lang')
        ->orderBy('lang')
        ->get();

            $result = $docs_per_lang->map(function ($lang, $key) use ($docs_per_lang) {
                return [
            'lang' => (string)$lang->lang,
            'count' => (int)$lang->documents_count,
            // 'href' => route('courts.documents.docsPerLang', ['court_acronym' => $this->acronym, 'lang' => $lang->lang]),
                ];
            });

            return $result;
        });
    }

    public function getDocsPerYearAttribute()
    {
        return Cache::rememberForever('docs_per_year' . $this->id, function () {
            $docs_per_year = $this->hasMany('App\Models\Document')
        ->select(DB::raw('count(*) as documents_count, year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();

            $result = $docs_per_year->map(function ($year, $key) use ($docs_per_year) {
                return [
            'year' => (int)$year->year,
            'count' => (int)$year->documents_count,
            // 'ecli_ref' => $this->ecli . ':' . $year->year,
            // 'href' => route('courts.documents.docsPerYear', ['court_acronym' => $this->acronym,'year' => $year->year]),
            ];
            });

            return $result;
        });
    }

    public function getDocsPerTypeAttribute()
    {
        return Cache::rememberForever('docs_per_type' . $this->id, function () {
            $docs_per_type = $this->hasMany('App\Models\Document')
        ->select(DB::raw('count(*) as documents_count, type'))
        ->groupBy('type')
        ->orderBy('type')
        ->get();

            $result = $docs_per_type->map(function ($type, $key) use ($docs_per_type) {
                return [
            'type' => (string)$type->type,
            'count' => (int)$type->documents_count,
            // 'href' => route('courts.documents.docsPerType', ['court_acronym' => $this->acronym, 'type' => $type->type]),
            // 'links' => [
            //     'parent' => $this->self_link,
            //     'self' => route('courts.documents.docsPerType', ['court_acronym' => $this->acronym, 'type' => $type->type]),
            //     ],
            ];
            });

            return $result;
        });
    }

    public function getECLIAttribute()
    {
        return "ECLI:BE:{$this->acronym}";
    }

    public function getRefAttribute()
    {
        return '/BE/' . $this->acronym . '/';
    }

    public function getHrefAttribute()
    {
        return route(
            'courts.show',
            ['court_acronym' => $this->acronym]
        );
    }

    public function getSelfLinkAttribute()
    {
        return route('courts.show', ['court_acronym' => $this->acronym]);
    }

    public function getParentLinkAttribute()
    {
        return route('base_ecli_be');
    }
}
