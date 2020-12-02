<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Storage;
use App\Models\Category;
use App\Models\Court;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateCourts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = (array)json_decode(file_get_contents('https://raw.githubusercontent.com/openjusticebe/resources/main/json/BE_Courts.json'), true);

        foreach ($data as $key => $category) {
            $cat = Category::updateOrCreate(
                [
                'label_fr' => $category['label_fr'],
                'label_nl' => $category['label_nl'],
                ]
            );


            foreach ($category['list'] as $key => $court) {
                Court::updateOrCreate(
                    [
                     'acronym' => $court['id'],
                     'category_id' => $cat->id,
                     ],
                    [
                     'name_nl' => $court['name_nl'] ?? null,
                     'name_fr' => $court['name_fr'] ?? null,
                     'name_de' => $court['name_de'] ?? null,
                     'def' => $court['def'] ?? null
                     ]
                );
            }
        }
    }
}
