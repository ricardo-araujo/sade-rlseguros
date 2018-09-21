<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => 'Suporte',
            'email' => 'suporte.licitacao@forseti.com.br',
            'password' => env('SENHA_USUARIO_SUPORTE')
        ]);

        User::firstOrCreate([
            'name' => 'Rezende',
            'email' => 'rlseguro@uol.com.br',
            'password' => env('SENHA_USUARIO_REZENDE')
        ]);

        User::firstOrCreate([
            'name' => 'sadebb',
            'email' => 'sade@forseti.com.br',
            'password' => env('SENHA_USUARIO_SADE')
        ]);
    }
}
