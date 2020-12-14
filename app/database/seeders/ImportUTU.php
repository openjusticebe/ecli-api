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
        Utu::truncate();

        $file_path = realpath('/var/www/database/seeders/UTU-src.json');
        $utu = json_decode(file_get_contents($file_path), true);

        // Create branch
        foreach ($utu as $record) {
            {
                if (!empty($record['Branch_FR']) && !empty($record['Branch_NL'])) {
                    Utu::firstOrCreate([
                                    'term_fr' => $record['Branch_FR'],
                                    'term_nl' => $record['Branch_NL'],
                                    'term_de' => null,
                                    'parent_id' => null
                                ]);
                }
            }
        }
        // Create Level 1 cat
        foreach ($utu as $record) {
            {
                    if (!empty($record['Branch_FR']) && !empty($record['Branch_NL'])) {
                        $parent = Utu::where('term_fr', $record['Branch_FR'])
                                ->where('term_nl', $record['Branch_NL'])
                                ->firstOrFail();
                                     
                        if (!empty($record['Lvl1_FR']) && !empty($record['Lvl1_NL'])) {
                            Utu::firstOrCreate([
                                'term_fr' => $record['Lvl1_FR'],
                                'term_nl' => $record['Lvl1_NL'],
                                'term_de' => null,
                                'parent_id' => $parent->id
                                ]);
                        }
                    }
                }
        }
            

        // Create Level 2 cat
        foreach ($utu as $record) {
            {
                    if (!empty($record['Branch_FR']) && !empty($record['Branch_NL'])) {
                        $parent = Utu::where('term_fr', $record['Lvl1_FR'])
                                ->where('term_nl', $record['Lvl1_NL'])
                                ->whereHas('parent', function ($q) use ($record) {
                                    $q->where('term_fr', $record['Branch_FR'])
                                    ->where('term_nl', $record['Branch_NL']);
                                })
                                ->first();
                                     
                        if (isset($parent) &&  !empty($record['Lvl2_FR']) && !empty($record['Lvl2_NL'])) {
                            Utu::firstOrCreate([
                                'term_fr' => $record['Lvl2_FR'],
                                'term_nl' => $record['Lvl2_NL'],
                                'term_de' => null,
                                'parent_id' => $parent->id
                                ]);
                        }
                    }
                }
        }

        // Create Level 3 cat
        foreach ($utu as $record) {
            {
                    if (!empty($record['Branch_FR']) && !empty($record['Branch_NL'])) {
                        $parent = Utu::where('term_fr', $record['Lvl2_FR'])
                                ->where('term_nl', $record['Lvl2_NL'])
                                ->whereHas('parent', function ($q) use ($record) {
                                    $q->where('term_fr', $record['Lvl1_FR'])
                                    ->where('term_nl', $record['Lvl1_NL'])->whereHas('parent', function ($qq) use ($record) {
                                        $qq->where('term_fr', $record['Branch_FR'])
                                        ->where('term_nl', $record['Branch_NL']);
                                    });
                                })
                                ->first();
                                     
                        if (isset($parent) && !empty($record['Lvl3_FR']) && !empty($record['Lvl3_NL'])) {
                            Utu::firstOrCreate([
                                'term_fr' => $record['Lvl3_FR'],
                                'term_nl' => $record['Lvl3_NL'],
                                'term_de' => null,
                                'parent_id' => $parent->id
                                ]);
                        }
                    }
                }
        }

        // Create Level 4 cat
        foreach ($utu as $record) {
            {
                        if (!empty($record['Branch_FR']) && !empty($record['Branch_NL'])) {
                            $parent = Utu::where('term_fr', $record['Lvl3_FR'])
                                    ->where('term_nl', $record['Lvl3_NL'])
                                    ->whereHas('parent', function ($q) use ($record) {
                                        $q->where('term_fr', $record['Lvl2_FR'])
                                        ->where('term_nl', $record['Lvl2_NL'])->whereHas('parent', function ($qq) use ($record) {
                                            $qq->where('term_fr', $record['Lvl1_FR'])
                                            ->where('term_nl', $record['Lvl1_NL'])->whereHas('parent', function ($qqq) use ($record) {
                                                $qqq->where('term_fr', $record['Branch_FR'])
                                                ->where('term_nl', $record['Branch_NL']);
                                            });
                                            ;
                                        });
                                    })
                                    ->first();

                            if (isset($parent) && !empty($record['Lvl4_FR']) && !empty($record['Lvl4_NL'])) {
                                Utu::firstOrCreate([
                                    'term_fr' => $record['Lvl4_FR'],
                                    'term_nl' => $record['Lvl4_NL'],
                                    'term_de' => null,
                                    'parent_id' => $parent->id
                                    ]);
                            }
                        }
                    }
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
        $db_count = Utu::count();
        $pct_completion = $db_count / count($utu) * 100;
        $this->command->info($db_count . ' / ' . count($utu) . ' (' . $pct_completion  . '%)');
    }
}
