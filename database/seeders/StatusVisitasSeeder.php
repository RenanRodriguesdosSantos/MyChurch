<?php

namespace Database\Seeders;

use App\Models\StatusVisitas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class StatusVisitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        StatusVisitas::create([
            'descricao' => 'Agendada',
            'slug' => 'agendada'
        ]);
        StatusVisitas::create([
            'descricao' => 'Realizada',
            'slug' => 'realizada'
        ]);
        Model::reguard();
    }
}
