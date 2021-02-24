<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;
use LanguageDetection\Language;

class checkLanguage extends Command
{
    protected $signature = 'bots:checkLanguage 
    {number_of_documents : Number of random document to load}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command ...';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $documents = Document::whereSrc('IUBEL')
        ->whereRaw('LENGTH(text) > 100')
        ->whereLang('undefined')
        ->inRandomOrder()
        ->take($this->argument('number_of_documents'))
        ->get();

        foreach ($documents as $doc) {
            $this->checkLang($doc);
        }
    }
    
    private function checkLang($doc)
    {
        $ld = new Language(['de', 'fr', 'nl', 'en']);
        
        $result = $ld->detect($doc->text)->bestResults()->close();

        if (current($result) > '0.5') {
            $this->updateLanguage($doc, key($result));
        } else {
            $this->info('Sorry, I am not sure!');
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

        $this->info($doc->id . ' is now ' . $lang);
    }
}
