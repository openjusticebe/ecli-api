<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class anonContent extends Command
{
    protected $signature = 'bots:anonContent 
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
        $json_request = [
                "_v" => 1,
                "_timestamp" => Carbon::now()->timestamp,
                "algo_list" => [
                  [
                    "id" => "anon_trazor",
                    "params" => "{\"method\":\"brackets\"}"
                  ],
                  [
                    "id" => "anon_mask",
                    "params" => "{}"
                  ],
                ],
                "format" => "text",
                "encoding" => "utf8",
                "text" => $doc->text
            ];
    
        $response = Http::post('https://upl.test.openjustice.lltl.be/run', $json_request);
        return $this->info(json_decode($response)->text);
    }
}



// curl -X POST "https://upl.test.openjustice.lltl.be/run" -H  "accept: application/json" -H  "Content-Type: application/json" -d "{\"_v\":1,\"_timestamp\":1239120938,\"algo_list\":[{\"id\":\"anon_trazor\",\"params\":\"{}\"}],\"format\":\"text\",\"encoding\":\"utf8\",\"text\":\"Robert serait le fils d'Erlebert et le neveu de Robert, référendaire de Dagobert Ier.\"}"
// response example
// {
//     "_v": 3,
//     "_timestamp": "2021-02-22T09:20:52.838833+00:00",
//     "log": {
//       "lines": [
//         "Found \"Dagobert Ier\" (person #1), score: 1.666",
//         "Found \"Robert\" (person #2), score: 0.5",
//         "Found \"Erlebert\" (person #3), score: 0.5",
//         "Found \"Robert\" (person #4), score: 0.5"
//       ]
//     },
//     "text": "<span class=\"pseudonymized person person_2\">person_2</span> serait le fils de <span class=\"pseudonymized person person_3\">person_3</span> et le neveu de <span class=\"pseudonymized person person_2\">person_2</span>, référendaire de <span class=\"pseudonymized person person_1\">person_1</span>."
//   }
