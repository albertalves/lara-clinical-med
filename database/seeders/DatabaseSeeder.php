<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CitiesTableSeeder::class);

        \App\Models\Doctor::factory(10)->create();
        \App\Models\Patient::factory(10)->create();
    }
}
