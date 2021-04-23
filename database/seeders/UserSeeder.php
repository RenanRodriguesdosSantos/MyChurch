<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tipo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        User::create([
            'name' => "Gustavo",
            'email' => "gustavo@gmail.com",
            'password' => Hash::make('gustavo123'),
            'type' => Tipo::where("slug","=","lider")->select('id')->first()->id
        ]);
        User::create([
            'name' => "Lucas",
            'email' => "lucas@gmail.com",
            'password' => Hash::make('lucas123'),
            'type' => Tipo::where("slug","=","obreiro")->select('id')->first()->id
        ]);
        User::create([
            'name' => "Renan",
            'email' => "renan@gmail.com",
            'password' => Hash::make('renan123'),
            'type' => Tipo::where("slug","=","porteiro")->select('id')->first()->id
        ]);
        Model::reguard();
    }
}
