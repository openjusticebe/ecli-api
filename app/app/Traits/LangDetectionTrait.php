<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Document;
use LanguageDetection\Language;

trait LangDetectionTrait
{
    protected function checkLang($doc)
    {
        $ld = new Language(['de', 'fr', 'nl', 'en']);
        
        $content = $doc->text . ' ' . $doc->meta;

        $result = $ld->detect($content)->bestResults()->close();

        if (current($result) > '0.5') {
            $this->updateLanguage($doc, key($result));
        }
    }

    private function updateLanguage($doc, $lang)
    {
        switch ($lang) {
            case 'fr':
                $lang = 'french';
                break;
            case 'nl':
                $lang = 'dutch';
                break;
            case 'en':
                $lang = 'english';
                break;
            case 'de':
                $lang = 'german';
                break;
            default:
            $lang = 'undefined';
            break;
        }
        $doc->lang = $lang;
        $doc->save();
    }
}
