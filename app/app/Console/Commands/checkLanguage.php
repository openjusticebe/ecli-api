<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;
use LanguageDetection\Language;
use App\Traits\ChecklangTrait;

class checkLanguage extends Command
{
    use ChecklangTrait;

    protected $signature = 'bots:checkLanguage 
    {number_of_documents : Number of random document to load}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command command will get a specific number of documents update lang.';

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
        $documents = Document::whereLang('undefined')
        ->inRandomOrder()
        ->take($this->argument('number_of_documents'))
        ->get();

        foreach ($documents as $document) {
            $this->checkLang($document);
        }
    }
}
