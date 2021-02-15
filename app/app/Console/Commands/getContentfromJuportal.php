<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;

class getContentfromJuportal extends Command
{
    protected $signature = 'bots:getContentfromJuportal 
    {number_of_documents : Number of random document to load}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command load document->text.';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $documents = Document::whereSrc('IUBEL')->whereNull('text')->inRandomOrder()->take($this->argument('number_of_documents'))->get();
        
        foreach ($documents as $doc) {
            $doc->markdown;
            $this->line($doc->ecli . '<fg=blue> text len:' . strlen($doc->text). '</><fg=red> meta len:' . strlen($doc->meta). '</>');
            sleep(rand(0, 2));
        }
    }
}
