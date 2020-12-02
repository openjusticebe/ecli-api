<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Storage;
use App\Models\Document;
use App\Models\Court;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ImportDataFromECLI extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sources = [
        'IUBEL' => 'https://raw.githubusercontent.com/openjusticebe/ecli/master/resources/IUBEL.txt',
        'GHCC' => 'https://raw.githubusercontent.com/openjusticebe/ecli/master/resources/GHCC_def.json',
        'RSCE' => 'https://raw.githubusercontent.com/openjusticebe/ecli/master/resources/RVSCDE_def.json'
        ];
    
        if ($this->command->confirm('Do like want to import ECLI into DB ?')) {
            foreach ($sources as $key => $value) {
                $this->command->info("Importing data from " . $key);

                // Get files from API
                $data = file_get_contents($value);
                
                // Loop and import into DB
                $lines = explode(PHP_EOL, $data);
        
                $output = new ConsoleOutput();
                $progress = new ProgressBar($output, count($lines));
                $progress->start();
        
                // Data is stored in .txt
                if ($key == 'IUBEL') {
                    // ECLI:BE:AHANT:2003:ARR.20030423.6
                    // ECLI:BE:AHANT:2004:ARR.20040604.5
                    // ECLI:BE:AHANT:2004:ARR.20040625.15
                    foreach ($lines as $line) {
                        $progress->advance();

                        $array = explode(":", $line);
                        if (isset($array[4])) {
                            $ecli = explode(".", $array[4]);
                            $court = Court::firstOrCreate(['acronym' => $array[2]]);
                            $num = $ecli[1] . '.' . $ecli[2];
                            Document::firstOrCreate(
                                [
                                'court_id' => $court->id,
                                'num' => $num,
                                'year' => $array[3],
                                'lang' => null,
                                'type' => strtoupper($ecli[0]) ?? null
                                ]
                            );
                        }
                    }
                    $progress->finish();
                    $this->command->info("");
                // Data is stored in .json (wrongly formatted)
                // GHCC
                // {"num": "035", "year": "2009", "language": "french", "type": "arr"}
                // {"num": "167", "year": "2005", "language": "french", "type": "arr"}
               
                // RSCE
                //   {"num": 200874, "year": 2010, "language": "french", "type": "arr"}
                // {"num": 142636, "year": 2005, "language": "dutch", "type": "arr"}
                // {"num": 246073, "year": 2019, "language": "dutch", "type": "arr"}
                // {"num": 208168, "year": 2010, "language": "french", "type": "arr"}
                } else {
                    $court = Court::firstOrCreate(['acronym' => $key]);
                    foreach ($lines as $line) {
                        $progress->advance();

                        $json = json_decode($line);
                        if (isset($json->num)) {
                            Document::firstOrCreate(
                                [
                            'court_id' => $court->id,
                            'num' => $json->num ?? null,
                            'year' => $json->year ?? null,
                            'lang' => $json->language ?? null,
                            'type' => strtoupper($json->type) ?? null,
                            ]
                            );
                        }
                    }
                    $progress->finish();
                    $this->command->info("");
                }
            }
        }
        $this->command->info("I'll never give you up.");
    }
}
