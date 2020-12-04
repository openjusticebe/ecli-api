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
        return "ELCI:BE:{$this->court->acronym}:{$this->year}:{$this->type}.{$this->num}";
    }

    public function getHrefAttribute()
    {
        return route(
            'documents.show',
            [
            'court_acronym' => $this->court->acronym,
            'year' => $this->year,
            'type' => $this->type,
            'num' => $this->num
            ],
        );
    }
}
