<?php

namespace App\Providers;

use App\Models\ReservaBB;
use App\Models\ReservaCN;
use App\Models\ReservaIO;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'bb' => ReservaBB::class,
            'cn' => ReservaCN::class, //Ver 'Polymorphic Relations' do Laravel para maiores entendimentos
            'io' => ReservaIO::class
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
