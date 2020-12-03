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
        
            return $result;
        });
    }

    public function getDocsPerTypeAttribute()
    {
        return Cache::rememberForever('docs_per_type' . $this->id, function () {
            $result = $this->hasMany('App\Models\Document')
        ->select(\DB::raw('count(*) as documents_count, year'))
        ->groupBy('type')
        ->get();


            return $result;
        });
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
