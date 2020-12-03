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
                'parent' => $this->self_link,
                'self' => $this->self_link . '/' . $year->year
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
            // 'elci_ref' => $this->elci . ':' . $type->type,
            // 'links' => [
            //     'parent' => $this->self_link,
            //     'self' => $this->self_link . '/' . $type->type
            //     ]
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
        return "ELCI/BE/{$this->acronym}";
    }
    public function getParentLinkAttribute()
    {
        return "ELCI/BE";
    }
}
