<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $visible = ['label'];

    public function getLabelAttribute()
    {
        $input = ['label_fr', 'label_nl', 'label_de'];
        $rand_keys = array_rand($input);
        $key = $input[$rand_keys];
        
        return $this->$key;
    }

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
