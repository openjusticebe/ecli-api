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

class getECLIsfromJuportal extends Command
{
    use ECLITrait;

    protected $signature = 'bots:getECLIsfromJuportal {date : The date to scrape YYYY-MM-DD}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command download ECLIs form Juportal search engine. It requires a date as argument.';

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

        // $this->info("Getting ECLI for date " . $date);

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

            $query = "/content/ECLI";
            if (substr($link, 0, strlen($query)) == $query) {
                $ecli = str_replace("/content/", "", $link);
                $ecli = substr($ecli, 0, strpos($ecli, "/"));
                if ($ecli != '') {
                    $eclis->push($ecli);
                }
            }
        });
        $this->storeECLIS($eclis->unique(), $date);
    }

    private function storeECLIS($eclis, $date)
    {
        $updated = 0;
        $created = 0;
        $gathered = $eclis->count();
       
        foreach ($eclis as $ecli) {
            $result = $this->explodeECLI($ecli, 'IUBEL');
                     
            $document = Document::updateOrCreate(
                $result,
                [
                    'meta' => json_encode("[{'decision_date': $date}]")
                ]
            );
            
            if (!$document->wasRecentlyCreated && $document->wasChanged()) {
                $updated++;
            }
               
            if ($document->wasRecentlyCreated) {
                $created++;
            }
            $this->line('<fg=blue>' .$document->ecli. '</>');
        }
        $this->info("[".$date."] " . "Gathered " . $eclis->count() . " ECLI(s): " . $updated . " updated and " . $created . " created.");
    }
}
