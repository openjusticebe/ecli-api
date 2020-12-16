<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Document;
use Illuminate\Database\Seeder;

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
                    $ecli = $country . ':' . $court . ':' . $year . ':' . $document;

                    $arr_type_num = explode('.', $document, 2);

                    $court = Court::firstOrCreate(['acronym' => $court]);
                    $document = Document::firstOrCreate(
                        [
                            'court_id' => $court->id,
                            'num' => strtoupper($arr_type_num[1]) ?? 'undefined',
                            'src' => "OJ",
                            'year' => $year,
                            'lang' => 'undefined',
                            'type' => strtoupper($arr_type_num[0]) ?? 'undefined',
                            ]
                    );
                }
            }
        }
    }
}
