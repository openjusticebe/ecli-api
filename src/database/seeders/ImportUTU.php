<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Models\Utu;

class ImportUTU extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = realpath('/var/www/database/seeders/UTU-src.json');
        $utu = json_decode(file_get_contents($file_path), true);

        foreach ($utu as $record) {
            foreach ($record as $key=>$line) {
                foreach ([
                    ['Branch_FR', 'Branch_NL'],
                    ["Lvl1_FR", "Lvl1_NL"],
                    ["Lvl2_FR", "Lvl2_NL"],
                    ["Lvl3_FR","Lvl3_NL"],
                    ["Lvl4_FR","Lvl4_NL"]
                    ] as $value) {
                    if ($record[$value[0]] != null) {
                        $utu = Utu::firstOrCreate([
                            'term_fr' => $record[$value[0]],
                            'term_nl' => $record[$value[1]],
                            'term_de' => null,
                        ]);
                        $utu->parent_id = isset($parent->id) ?? $parent->id :: null;
                        $utu->save();

                        $parent = $utu;
                    }

                    $this->command->info($utu);
                }


                // EX
                // "Branch_FR": "DROIT JUDICIAIRE",
                // "Lvl1_FR": "DROIT JUDICIAIRE - PRINCIPES GÉNÉRAUX",
                // "Lvl2_FR": "Principes généraux droit judiciaire",
                // "Lvl3_FR": "Généralités ",
                // "Lvl4_FR": "",
                // "Branch_NL": "GERECHTELIJK RECHT",
                // "Lvl1_NL": "GERECHTELIJK RECHT- ALGEMENE BEGINSELEN",
                // "Lvl2_NL": "Algemene beginselen",
                // "Lvl3_NL": "Algemeen",
                // "Lvl4_NL": ""
            }
        }

        // $country = "BE";
        // $country_params = ["country" => $country];
        // $country_params = json_encode($country_params);

        // $base_api = "https://doc.openjustice.lltl.be/list?level=court&data=" . $country_params;
        
        // $courts = file_get_contents($base_api);
        // $courts = json_decode($courts);

        // foreach ($courts as $court) {
        //     $court_params = json_encode(["country" => "BE", "court"  => $court]);
        //     $base_api = "https://doc.openjustice.lltl.be/list?level=year&data=" . $court_params;
        //     $years = file_get_contents($base_api);
        //     $years = json_decode($years);
        //     foreach ($years as $year) {
        //         $full_params = json_encode(["country" => "BE", "court" => $court, "year" => $year]);
        //         $base_api = "https://doc.openjustice.lltl.be/list?level=document&data=" . $full_params;
        //         $documents = file_get_contents($base_api);
        //         $documents = json_decode($documents);
                
        //         foreach ($documents as $document) {
        //             $ecli = $country . ':' . $court . ':' . $year . ':'. $document;

        //             $arr_type_num = explode('.', $document, 2);

        //             $court = Court::firstOrCreate(['acronym' => $court]);
        //             $document = Document::firstOrCreate(
        //                 [
        //                     'court_id' => $court->id,
        //                     'num' => strtoupper($arr_type_num[1]) ?? 'undefined',
        //                     'src' => "OJ",
        //                     'year' => $year,
        //                     'lang' => 'undefined',
        //                     'type' => strtoupper($arr_type_num[0]) ?? 'undefined'
        //                     ]
        //             );
        //         }
        //     }
        // }
    }
}
