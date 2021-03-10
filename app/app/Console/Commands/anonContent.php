<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Traits\AnonTrait;

class anonContent extends Command
{
    use AnonTrait;

    protected $signature = 'bots:anonContent 
    {number_of_documents : Number of random document to load}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command command will get a specific number of random documents and anon the content.';

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
        ->where('text', '!=', '')
        ->whereNotNull('text')
        ->inRandomOrder()
        ->take($this->argument('number_of_documents'))
        ->get();
        
        foreach ($documents as $doc) {
            $this->anon($doc);
        }
    }
    
    private function anon($doc)
    {
        $response = $this->anonText($doc->text);

        return $this->info($response);
    }
}
