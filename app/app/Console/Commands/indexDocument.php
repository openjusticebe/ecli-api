<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Court;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Elasticsearch\ClientBuilder;
use Carbon\Carbon;
use App\Http\Resources\DocumentResource;
use App\Traits\ESTrait;

class indexDocument extends Command
{
    use ESTrait;

    protected $signature = 'bots:indexDocument';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command will index Model::Document into ES is $document->text IS NOT null';

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
        $docs = Document::whereNotNull('text')->get();

        $this->info($docs->count());

        foreach ($docs as $document) {
            $this->putDocumentInES($document);
        }
    }

    private function putDocumentInEs($document)
    {
        $return = $this->indexDocument($document);  // method from ESTrait
        
        $this->line($return['result'] . ' <fg=blue>' .$document->ecli. '</>');
    }
}
