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

    public function years()
    {
        return $this->hasMany('App\Models\Document')->;
    }


}
