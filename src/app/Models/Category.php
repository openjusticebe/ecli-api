<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function courts()
    {
        return $this->hasMany('App\Models\Court');
    }
}
