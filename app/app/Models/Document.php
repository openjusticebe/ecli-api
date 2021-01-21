<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year', 'identifier', 'type', 'src', 'lang', 'text', 'meta', 'court_id'
    ];
    
    public function court()
    {
        return $this->belongsTo('App\Models\Court');
    }

    public function getECLIAttribute()
    {
        return "ECLI:BE:{$this->court->acronym}:{$this->year}:{$this->type_identifier}";
    }

    public function getTypeIdentifierAttribute()
    {
        return $this->type . '.' . $this->identifier;
    }

    public function getHrefAttribute()
    {
        return route(
            'documents.show',
            [
            'court_acronym' => $this->court->acronym,
            'year' => $this->year,
            'type_identifier' => $this->type_identifier,
             ],
        );
    }

    public function getSelfLinkAttribute()
    {
        return route(
            'documents.show',
            [
            'court_acronym' => $this->court->acronym,
            'year' => $this->year,
            'type_identifier' => $this->type_identifier,
             ],
        );
    }

    public function getParentLinkAttribute()
    {
        return route('courts.show', ['court_acronym' => $this->court->acronym]);
    }

    public function getRefAttribute()
    {
        return '/BE/' . $this->court->acronym . '/' . $this->year . '/' . $this->type_identifier;
    }

    public function getLinksAttribute()
    {
        if ($this->src == 'GHCC') {
            return [
                [
                 'rel' =>  'default',

                 'href' => "https://www.const-court.be/public/f/" . $this->year . '/' . $this->year . '-' . sprintf("%03d", $this->identifier) . 'f.pdf',
                ],
                [
                    'rel' =>  'pdf',
                    'href' => "https://www.const-court.be/public/f/" . $this->year . '/' . $this->year . '-' . sprintf("%03d", $this->identifier) . 'f.pdf',
                ],
            ];
        } elseif ($this->src == 'RSCE') {
            return [
                [
                 'rel' =>  'default',
                 'href' => "http://www.raadvst-consetat.be/arr.php?nr=" . $this->identifier,
                ],
                [
                    'rel' =>  'pdf',
                    'href' => "http://www.raadvst-consetat.be/arr.php?nr=" . $this->identifier,
                ],
            ];
        } elseif ($this->src == 'IUBEL') {
            return [
                [
                 'rel' =>  'default',
                 'href' => "https://juportal.be/content/" . $this->ecli,
                ],
                [
                    'rel' =>  'pdf',
                    'href' => "https://juportal.be/content/" . $this->ecli,
                ],
            ];
        } else {
            return [
                [
                 'rel' =>  'default',
                 'href' => "https://doc.openjustice.lltl.be/html/" . $this->ecli,
                ],
                [
                  'rel' =>  'html',
                  'href' => "https://doc.openjustice.lltl.be/html/" . $this->ecli,
                ],
            ];
        }
    }
}
