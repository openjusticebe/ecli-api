<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Storage;
use App\Models\Document;
use App\Models\Court;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ImportDataFromOJ extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = "BE";
        $country_params = ["country" => $country];
        $country_params = json_encode($country_params);

        $base_api = "https://doc.openjustice.lltl.be/list?level=court&data=" . $country_params;
        
        $courts = file_get_contents($base_api);
        $courts = json_decode($courts);

        foreach ($courts as $court) {
            $court_params = json_encode(["country" => "BE", "court"  => $court]);
            $base_api = "https://doc.openjustice.lltl.be/list?level=year&data=" . $court_params;
            $years = file_get_contents($base_api);
            $years = json_decode($years);
            foreach ($years as $year) {
                $full_params = json_encode(["country" => "BE", "court" => $court, "year" => $year]);
                $base_api = "https://doc.openjustice.lltl.be/list?level=document&data=" . $full_params;
                $documents = file_get_contents($base_api);
                $documents = json_decode($documents);
                
                foreach ($documents as $document) {
                    $ecli = $country . ':' . $court . ':' . $year . ':'. $document;
                    $this->command->info($ecli);


                    $ecli = explode(".", $document);
                    $court = Court::firstOrCreate(['acronym' => $court]);
                    $document = Document::firstOrCreate(
                        [
                            'court_id' => $court->id,
                            'num' => $document,
                            'src' => "OJ",
                            'year' => $year,
                            'lang' => 'undefined',
                            'type' => strtoupper($ecli[0]) ?? 'undefined'
                            ]
                    );
                }
            }
        }
       
        $this->command->info("I'll never give you up.");
    }
}
