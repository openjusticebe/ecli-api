<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use League\HTMLToMarkdown\HtmlConverter;
use App\Models\Court;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Traits\ECLITrait;

class ScrapeJuportal extends Command
{
    use ECLITrait;

    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:scrape
    {date : The date to scrape YYYY-MM-DD}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command download ECLI form Juportal search engine. It requires a date as argument.';

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
        $client = new Client();

        $date = $this->argument('date');

        $this->info("Getting ECLI for date " . $date);

        $crawler = $client->request('GET', 'https://juportal.be/moteur/formulaire');

        $buttonCrawler = $crawler->selectButton('Rechercher');
        
        $form = $buttonCrawler->form();
        $pageCrawler = $client->submit(
            $form,
            [
                'latitude' => "",
                'longitude' => "",
                'accuracy' => "",
                'altitude' => "",
                'altitudeAccuracy' => "",
                'TEXPRESSION' => "",
                'TRECHTEXTE' => "on",
                'TRECHMOCLELIB' => "on",
                'TRECHRESUME' => "on",
                'TRECHNOTE' => "on",
                'TRECHLANGNL' => "on",
                'TRECHLANGFR' => "on",
                'TRECHLANGDE' => "on",
                'TRECHECLINUMERO' => "",
                'TRECHNOROLE' => "",
                'TRECHDECISIONDE' => $date,
                'TRECHDECISIONA' => $date,
                'TRECHPUBLICATDE' => "",
                'TRECHPUBLICATA' => "",
                'TRECHBASELEGDATE' => "",
                'TRECHBASELEGNUM' => "",
                'TRECHBASELEGART' => "",
                'TRECHMODE' => "BOOLEAN",
                'TRECHOPER' => "AND",
                'TRECHSCORE' => "0",
                'TRECHLIMIT' => "50000",
                'TRECHNPPAGE' => "1000",
                'TRECHHILIGHT' => "on",
                'TRECHSHOWRESUME' => "on",
                'TRECHSHOWTHECAS' => "on",
                'TRECHSHOWTHEUTU' => "on",
                'TRECHSHOWMOTLIB' => "on",
                'TRECHSHOWFICHES' => "ALL",
                'TRECHORDER' => "SCORE",
                'TRECHDESCASC' => "DESC",
                'action' => "",
            ]
        );

        $eclis = collect();

        $pageCrawler->filter('a')->each(function ($node) use ($eclis) {
            $link = $node->attr('href');

            $query = "/content/";
            if (substr($link, 0, strlen($query)) == $query) {
                $ecli = str_replace($query, "", $link);
                $ecli = substr($ecli, 0, strpos($ecli, "/"));
                if ($ecli != '') {
                    $eclis->push($ecli);
                }
            }
        });
        $this->storeECLIS($eclis->unique());
    }

    private function storeECLIS($eclis)
    {
        $this->info("Gathered ". $eclis->count() . " ECLI code");
    
        
        foreach ($eclis as $ecli) {
            $result = $this->explodeECLI($ecli, 'IUBEL');
                     
            Document::firstOrCreate($result);
        }
        $this->info("Stored ". $eclis->count() . " new ECLIs");
    }
}
