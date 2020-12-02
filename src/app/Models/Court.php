<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function docsPerYear()
    {
        return $this->hasMany('App\Models\Document')
        ->select(\DB::raw('count(*) as documents_count, year'))->groupBy('year');
    }

    public function docsPerType()
    {
        return $this->hasMany('App\Models\Document')
        ->select(\DB::raw('count(*) as documents_count, type'))->groupBy('type');
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
