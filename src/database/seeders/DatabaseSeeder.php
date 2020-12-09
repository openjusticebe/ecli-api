<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateCourts::class);
        $this->call(ImportDataFromECLI::class);
        $this->call(ImportDataFromOJ::class);
        $this->command->info("Please remember: Unicorns 🦄 and Pirates 🏴‍☠️ love Pizzas 🍕");
        $this->command->info("But more importantly, remember that: I WILL NEVER GONNA GIVE YOU UP ❤️🎼");
    }
}
