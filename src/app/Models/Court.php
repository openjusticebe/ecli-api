<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Court extends Model
{
    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function getDocsPerLangAttribute()
    {
        return Cache::rememberForever('docs_per_lang' . $this->id, function () {
            $docs_per_lang = $this->hasMany('App\Models\Document')
        ->select(\DB::raw('count(*) as documents_count, lang'))
        ->groupBy('lang')
        ->get();
        
            $result = $docs_per_lang->map(function ($lang, $key) use ($docs_per_lang) {
                return [
            'lang' => $lang->lang,
            'count' => (int)$lang->documents_count,
            'links' => [
                'parent' => $this->self_link,
                'self' =>  route('courts.docsPerLang', ['court_acronym' => $this->acronym, 'lang' => $lang->lang])
                ]
            ];
            });

            return $result;
        });
    }

    public function getDocsPerYearAttribute()
    {
        return Cache::rememberForever('docs_per_year' . $this->id, function () {
            $docs_per_year = $this->hasMany('App\Models\Document')
        ->select(\DB::raw('count(*) as documents_count, year'))
        ->groupBy('year')
        ->get();
        
            $result = $docs_per_year->map(function ($year, $key) use ($docs_per_year) {
                return [
            'year' => (int)$year->year,
            'count' => (int)$year->documents_count,
            'elci_ref' => $this->elci . ':' . $year->year,
            'links' => [
                'parent' =>  $this->self_link,
                'self' =>  route('courts.docsPerYear', ['court_acronym' => $this->acronym,'year' => $year->year])
                ]
            ];
            });

            return $result;
        });
    }

    public function getDocsPerTypeAttribute()
    {
        return Cache::rememberForever('docs_per_type' . $this->id, function () {
            $docs_per_type = $this->hasMany('App\Models\Document')
        ->select(\DB::raw('count(*) as documents_count, type'))
        ->groupBy('type')
        ->get();
        
            $result = $docs_per_type->map(function ($type, $key) use ($docs_per_type) {
                return [
            'type' => $type->type,
            'count' => (int)$type->documents_count,
            'links' => [
                'parent' => $this->self_link,
                'self' => route('courts.docsPerType', ['court_acronym' => $this->acronym, 'type' => $type->type])
                ]
            ];
            });

            return $result;
        });
    }

    public function getELCIAttribute()
    {
        return "ELCI:BE:{$this->acronym}";
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
