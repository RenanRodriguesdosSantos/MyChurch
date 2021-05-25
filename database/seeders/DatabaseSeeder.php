<?php

namespace Database\Seeders;

use App\Models\StatusVisitas;
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
        $this->call([
            TipoSeeder::class,
            UserSeeder::class,
            EventoStatusSeeder::class,
            StatusVisitasSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
