<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use League\HTMLToMarkdown\HtmlConverter;
use Cache;

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

    public function getMarkdownAttribute()
    {
        return Cache::rememberForever('document_text_' . $this->id, function () {
            $client = new Client();
            $crawler = $client->request('GET', $this->link);

            $html = $crawler->filter('#plaintext')->each(function ($node) {
                return $node->html();
            });

            $converter = new HtmlConverter();

            $markdown = $converter->convert(implode('<br />', $html));

            return $markdown;
        });
    }

    public function getParentLinkAttribute()
    {
        return route('courts.show', ['court_acronym' => $this->court->acronym]);
    }

    public function getRefAttribute()
    {
        return '/BE/' . $this->court->acronym . '/' . $this->year . '/' . $this->type_identifier;
    }

    public function getLinkAttribute()
    {
        if ($this->src == 'GHCC') {
            return  "https://www.const-court.be/public/f/" . $this->year . '/' . $this->year . '-' . sprintf("%03d", $this->identifier) . 'f.pdf';
        } elseif ($this->src == 'RSCE') {
            return "http://www.raadvst-consetat.be/arr.php?nr=" . $this->identifier;
        } elseif ($this->src == 'IUBEL') {
            return "https://juportal.be/content/" . $this->ecli;
        } else {
            return "https://doc.openjustice.lltl.be/html/" . $this->ecli;
        }
    }
}
