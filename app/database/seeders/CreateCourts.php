<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Court;
use Illuminate\Database\Seeder;

class CreateCourts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = (array)json_decode(file_get_contents('https://raw.githubusercontent.com/openjusticebe/resources/main/json/BE_Courts.json'), true);

        foreach ($json as $key => $category) {
            $cat = Category::updateOrCreate(
                [
                'label_fr' => $category['label_fr'],
                'label_nl' => $category['label_nl'],
                'label_de' => $category['label_de'],
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
                     'court_href' => $court['court_href'] ?? null,
                     'logo_href' => $court['logo_href'] ?? null,
                     'def' => $court['def'] ?? null,
                     ]
                );
            }
        }
    }
}
