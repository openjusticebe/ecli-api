<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public function court()
    {
        return $this->belongsTo('App\Models\Court');
    }

    public function getECLIAttribute()
    {
        return "ECLI:BE:{$this->court->acronym}:{$this->year}:{$this->type_num}";
    }

    public function getTypeNumAttribute()
    {
        return $this->type . '.' . $this->num;
    }

    public function getHrefAttribute()
    {
        return route(
            'documents.show',
            [
            'court_acronym' => $this->court->acronym,
            'year' => $this->year,
            'type_num' => $this->type_num,
             ],
        );
    }

    public function getRefAttribute()
    {
        return '/BE/' . $this->court->acronym . '/' . $this->year . '/' . $this->type_num;
    }

    public function getLinksAttribute()
    {
        if ($this->src == 'GHCC') {
            return [
                [
                 'rel' =>  'default',
                 
                 'href' => "https://www.const-court.be/public/f/" . $this->year . '/' . $this->year . '-' . sprintf("%03d", $this->num) . 'f.pdf'
                ],
                [
                    'rel' =>  'pdf',
                    'href' => "https://www.const-court.be/public/f/" . $this->year . '/' . $this->year . '-' . sprintf("%03d", $this->num) . 'f.pdf'
                ],
            ];
        } elseif ($this->src == 'RSCE') {
            return [
                [
                 'rel' =>  'default',
                 'href' => "http://www.raadvst-consetat.be/arr.php?nr=" . $this->num
                ],
                [
                    'rel' =>  'pdf',
                    'href' => "http://www.raadvst-consetat.be/arr.php?nr=" . $this->num
                ],
            ];
        } elseif ($this->src == 'IUBEL') {
            return [
                [
                 'rel' =>  'default',
                 'href' => "https://iubel.be/IUBELcontent/ViewDecision.php?id=" . $this->ecli
                ],
                [
                    'rel' =>  'pdf',
                    'href' => "https://iubel.be/IUBELcontent/ViewDecision.php?id=" . $this->ecli
                ],
            ];
        } else {
            return [
                [
                 'rel' =>  'default',
                 'href' => "https://ecli.openjustice.be/html/" . $this->ecli
                ],
                [
                  'rel' =>  'html',
                  'href' => "https://ecli.openjustice.be/html/{eclip.raw}" . $this->ecli
                ],
            ];
        };
    }
}
