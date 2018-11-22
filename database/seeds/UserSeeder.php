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
            'email' => 'suporte.licitacao@forseti.com.br'
        ],
        [
            'name' => 'Suporte',
            'password' => env('SENHA_USUARIO_SUPORTE')
        ]);

        User::firstOrCreate([
            'email' => 'rlseguro@uol.com.br',
        ],
        [
            'name' => 'Rezende',
            'password' => env('SENHA_USUARIO_REZENDE')
        ]);

        User::firstOrCreate([
            'email' => 'sade@forseti.com.br'
        ],
        [
            'name' => 'sadebb',
            'password' => env('SENHA_USUARIO_SADE')
        ]);
    }
}
