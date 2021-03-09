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
use Carbon\Carbon;

class getECLIsfromJuportal extends Command
{
    use ECLITrait;

    protected $signature = 'bots:getECLIsfromJuportal 
    {start_date : Start date to scrape YYYY-MM-DD} 
    {end_date? : End date to scrape YYYY-MM-DD}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command download ECLIs form Juportal search engine. It requires a start_date and end_date as arguments.';

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

        $date = Carbon::now();
        
        $start_date = $this->argument('start_date');

        if (empty($this->argument('end_date'))) {
            $end_date = new Carbon($start_date);
            $end_date = $end_date->addMonths(1)->format('Y-m-d');
        } else {
            $end_date = $this->argument('end_date');
        }

        $this->info('From ' . $start_date . " to " . $end_date);

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
                'TRECHDECISIONDE' => $start_date,
                'TRECHDECISIONA' => $end_date,
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
            $title = $node->attr('title');

            $query = "ECLI:";
            if (substr($title, 0, strlen($query)) == $query) {
                if ($title != '') {
                    $eclis->push($title);
                }
            }
        });
        $this->storeECLIS($eclis->unique());
    }

    private function storeECLIS($eclis)
    {
        $updated = 0;
        $created = 0;
        $gathered = $eclis->count();
       
        foreach ($eclis as $ecli) {
            $result = $this->explodeECLI($ecli);
                     
            $document = Document::updateOrCreate(
                $result,
                ['src' => 'IUBEL']
            );

            $operation = "  Found > ";
            
            if (!$document->wasRecentlyCreated && $document->wasChanged()) {
                $updated++;
                $operation = "Updated > " ;
            }
               
            if ($document->wasRecentlyCreated) {
                $created++;
                $operation = "Created > " ;
            }
            $this->line($operation . '<fg=blue>' .$document->ecli. '</>');
        }
        $this->info("Gathered " . $eclis->count() . " ECLI(s): " . $updated . " updated and " . $created . " created.");
    }
}
