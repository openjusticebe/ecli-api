<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function court()
    {
        return $this->belongsTo('App\Models\Court');
    }

    public function getELCIAttribute()
    {
        return "'ELCI:BE:'{$this->court->acronym}:{$this->court->acronym}:{$this->court->acronym}";
    }
}
