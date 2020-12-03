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
        return "'ELCI:BE:'{$this->court->acronym}:{$this->year}:{$this->type}:{$this->num}";
    }

    public function getSelfLinkAttribute()
    {
        return route(
            'documents.show',
            [$this->court->acronym,$this->year,$this->type,$this->num]
        );
    }

    public function getParentLinkAttribute()
    {
        return route('courts.docsPerYear', [$this->court->acronym,$this->year]);
    }
}
