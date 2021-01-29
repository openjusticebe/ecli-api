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
    public function storeSrcContent()
    {
        return Cache::rememberForever('document_src_' . $this->id, function () {
            $client = new Client();
            $crawler = $client->request('GET', $this->link);
            return $crawler;
        });
    }

    private function grabJurportal()
    {
        // $crawler = $this->storeSrcContent();

        $client = new Client();
        $crawler = $client->request('GET', $this->link);
        
        $html = $crawler->filter('#plaintext')->each(function ($node) {
            return $node->html();
        });

        // To markdown
        $converter = new HtmlConverter();
        $markdown = $converter->convert(implode('<br />', $html));
        $this->text = $markdown;

        $proprieties = $crawler->filter('tbody')->filter('tr')->each(function ($tr, $i) {
            return $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
        });

        $pdf = $crawler->filter('#text')->filter('a')->each(function ($node) {
            if (substr($node->attr('href'), -4) == '.pdf') {
                return $node->attr('href');
            }
        });

        $fiche = $crawler->filter('fieldset')->filter('.plaintext')->each(function ($node) {
            return $node->text();
        });

        array_push($proprieties, ['pdf', $pdf[0] ?? null]);
        array_push($proprieties, ['fiche', $fiche[0] ?? null]);
        
        $this->meta = json_encode($proprieties);


        $this->save();
    }

    private function grabData()
    {
        switch ($this->src) {
            case 'IUBEL':
                $this->grabJurportal();
                break;
            case 'GHCC':
                break;
            case 'RSCE':
                break;
            case 'OJ':
                break;
            default:
                return null;
    }
    }
    public function getMetadataAttribute()
    {
        if (empty($this->meta)) {
            $this->grabData();
        }

        return $this->meta;
    }

    public function getMarkdownAttribute()
    {
        if (empty($this->text)) {
            $this->grabData();
        }

        return $this->text;
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
        switch ($this->src) {
            case 'IUBEL':
                return "https://juportal.be/content/" . $this->ecli;
            case 'GHCC':
                return  "https://www.const-court.be/public/f/" . $this->year . '/' . $this->year . '-' . sprintf("%03d", $this->identifier) . 'f.pdf';
            case 'RSCE':
                return "http://www.raadvst-consetat.be/arr.php?nr=" . $this->identifier;
            case 'OJ':
                 return "https://doc.openjustice.lltl.be/html/" . $this->ecli;
            default:
            return null;

        }
    }
}
