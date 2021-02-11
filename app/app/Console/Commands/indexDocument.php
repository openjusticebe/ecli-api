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

class indexDocument extends Command
{
    protected $signature = 'bots:indexDocument';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command will index Model::Document into ES';

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
        $docs = Document::whereNotNull('text')->where('text', '!=', '')->get();

        foreach ($docs as $document) {
            $this->putDocumentInES($document);
        }
    }

    private function putDocumentInEs($document)
    {
        $hosts = ['http://' . env('ELASTIC_HOST', 'localhost') . ':9200'];

        $data = [
            'body' => [
                'identifier' => $document->identifier,
                'type' => $document->type,
                'type_identifier' => $document->type_identifier,
                'year' => (int)$document->year,
                'lang' => $document->lang,
                'ecli' => $document->ecli,
                'src' => $document->src,
                'meta' => null,
                'text' => $document->markdown,
                'ref' => $document->ref,
                'link' => $document->link,
            ],
                'index' => 'ecli',
                'type' => 'documents',
                'id' => $document->id,
            ];
    
        $clientBuilder = ClientBuilder::create();   // Instantiate a new ClientBuilder
        $clientBuilder->setHosts($hosts);           // Set the hosts
        $client = $clientBuilder->build();

        $return = $client->index($data);
        
        $this->line($return['result'] . ' <fg=blue>' .$document->ecli. '</>');

        // $params = [
        //     'index' => 'my_index',
        //     'type' => 'my_type',
        //     'id' => 'my_id'
        // ];
        
        // $response = $client->get($params);
        // dd($response);
    }
}
