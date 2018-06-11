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
        User::create([
            'name' => 'Suporte',
            'email' => 'suporte.licitacao@forseti.com.br',
            'password' => env('SENHA_USUARIO_SUPORTE')
        ]);

        User::create([
            'name' => 'Rezende',
            'email' => 'rlseguro@uol.com.br',
            'password' => env('SENHA_USUARIO_REZENDE')
        ]);
    }
}
