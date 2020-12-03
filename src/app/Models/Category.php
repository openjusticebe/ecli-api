<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function courts()
    {
        return $this->hasMany('App\Models\Court');
    }

    public function getSelfLinkAttribute()
    {
        return "ELCI/BE/";
    }

    public function getParentLinkAttribute()
    {
        return "null";
    }
}
