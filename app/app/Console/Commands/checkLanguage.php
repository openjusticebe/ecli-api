<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;
use LanguageDetection\Language;
use App\Traits\LangDetectionTrait;

class checkLanguage extends Command
{
    use LangDetectionTrait;

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
        $documents = Document::whereNull('lang')
        ->inRandomOrder()
        ->take($this->argument('number_of_documents'))
        ->get();

        foreach ($documents as $document) {

            $old = $document->lang;
            $this->checkLang($document);
            $new = $document->lang;
            
            $this->info("Document {$document->id} lang changed from {$old} to {$new}");

            // $this->info($document->self_link);
        }
    }
}
