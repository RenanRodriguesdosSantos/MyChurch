<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Tipo::create([
            'descricao' => 'Lider',
            'slug' => 'lider'
        ]);
        Tipo::create([
            'descricao' => 'Obreiro',
            'slug' => 'obreiro'
        ]);
        Tipo::create([
            'descricao' => 'Porteiro',
            'slug' => 'porteiro'
        ]);
        Model::reguard();

    }
}
