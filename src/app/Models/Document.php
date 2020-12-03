<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function court()
    {
        return $this->belongsTo('App\Models\Court');
    }

    public function getElciAttribute()
    {
        return "'ELCI:BE:'{$this->court->acronym}:{$this->type}:{$this->num}";
    }

    public function getSelfLinkAttribute()
    {
        return "ELCI/BE/{$this->court->acronym}/";
    }

    public function getParentLinkAttribute()
    {
        return "ELCI/BE/{$this->court->acronym}";
    }
}
