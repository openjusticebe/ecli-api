<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Document;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Traits\ECLITrait;

class ImportDataFromECLI extends Seeder
{
    use ECLITrait;

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
        'RSCE' => 'https://raw.githubusercontent.com/openjusticebe/ecli/master/resources/RVSCDE_def.json',
        ];

        foreach ($sources as $key => $value) {
            $this->command->info("Importing data from " . $key);

            // Get files from API
            $data = file_get_contents($value);

            $lines = explode(PHP_EOL, $data);

            $output = new ConsoleOutput();
            $progress = new ProgressBar($output, count($lines));
            $progress->start();

            // Data is stored in .txt
            if ($key == 'IUBEL') {
                // ECLI:BE:AHANT:2003:ARR.20030423.6
                // ECLI:BE:AHANT:2004:ARR.20040604.5
                // ECLI:BE:AHANT:2004:ARR.20040625.15

                // Loop and import into DB
                foreach ($lines as $ecli) {
                    if (isset($ecli)) {
                        $progress->advance();
                   
                        $result = $this->explodeECLI($ecli);
                        
                        Document::updateOrCreate($result, ['src' => $key]);
                    }
                }
                $progress->finish();
                $this->command->info("");
            // Data is stored in .json (wrongly formatted)
                // GHCC
                // {"num": "035", "year": "2009", "language": "french", "type": "arr"}
                // {"num": "167", "year": "2005", "language": "french", "type": "arr"}

                // RSCE
                // {"num": 200874, "year": 2010, "language": "french", "type": "arr"}
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
                            'identifier' => $json->num ?? 'undefined',
                            'year' => $json->year ?? 'undefined',
                            'src' => $key,
                            'lang' => $json->language ?? 'undefined',
                            'type' => strtoupper($json->type) ?? 'undefined',
                            ]
                        );
                    }
                }
                $progress->finish();
                $this->command->info("");
            }
        }
    }
}
