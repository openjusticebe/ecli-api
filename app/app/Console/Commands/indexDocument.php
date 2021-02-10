<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Court;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Elasticsearch\ClientBuilder;
use Carbon\Carbon;

class indexDocument extends Command
{
    protected $signature = 'bots:indexDocument';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command will index document';

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
        $data = [
            'body' => [
                'testField' => 'abddc'
            ],
                'index' => 'my_index',
                'type' => 'my_type',
                'id' => 'my_id',
            ];
    
        $hosts = ['http://es:9200'];

        $clientBuilder = ClientBuilder::create();   // Instantiate a new ClientBuilder
        $clientBuilder->setHosts($hosts);           // Set the hosts
        $client = $clientBuilder->build();          // Set the hosts

        $return = $client->index($data);
        
        // $this->info(dd($return));
        
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];
        
        $response = $client->get($params);
        dd($response);
    }
}
