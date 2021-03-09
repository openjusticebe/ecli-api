<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Document;
use Illuminate\Database\Seeder;
use App\Traits\ECLITrait;

class ImportDataFromOJ extends Seeder
{
    use ECLITrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $BASE_URL = "https://doc.openjustice.lltl.be/list?level=";
        
        $country = "BE";
        $country_params = ["country" => $country];
        $country_params = json_encode($country_params);

        $API_URL = $BASE_URL . "court&data=" . $country_params;

        $courts = file_get_contents($API_URL);
        $courts = json_decode($courts);

        foreach ($courts as $court) {
            $court_params = json_encode(["country" => "BE", "court"  => $court]);
            $API_URL = $BASE_URL . "year&data=" . $court_params;
            
            $years = file_get_contents($API_URL);
            $years = json_decode($years);
            
            foreach ($years as $year) {
                $full_params = json_encode(["country" => "BE", "court" => $court, "year" => $year]);
                $API_URL = $BASE_URL . "document&data=" . $full_params;
            
                $documents = file_get_contents($API_URL);
                $documents = json_decode($documents);

                foreach ($documents as $document) {
                    $ecli = "ECLI:" . $country . ':' . $court . ':' . $year . ':' . $document;

                    $result = $this->explodeECLI($ecli);
                        
                    Document::updateOrCreate($result, ['src' => 'OJ']);
                }
            }
        }
    }
}
