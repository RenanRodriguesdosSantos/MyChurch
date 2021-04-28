<?php

namespace Database\Seeders;

use App\Models\EventoStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class EventoStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        EventoStatus::create([
            'nome' => 'Realizado'
        ]);
        EventoStatus::create([
            'nome' => 'Não realizado'
        ]);
        Model::reguard();

    }
}
