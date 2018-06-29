<?php

namespace App\Providers;

use App\Models\LicitacaoBB;
use App\Models\LicitacaoCN;
use App\Models\LicitacaoIO;
use App\Models\ReservaBB;
use App\Models\ReservaCN;
use App\Models\ReservaIO;
use App\Observers\LicitacaoBBObserver;
use App\Observers\LicitacaoCNObserver;
use App\Observers\LicitacaoIOObserver;
use App\Observers\ReservaBBObserver;
use App\Observers\ReservaCNObserver;
use App\Observers\ReservaIOObserver;
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

        LicitacaoBB::observe(LicitacaoBBObserver::class);
        LicitacaoCN::observe(LicitacaoCNObserver::class);
        LicitacaoIO::observe(LicitacaoIOObserver::class);
        ReservaBB::observe(ReservaBBObserver::class);
        ReservaCN::observe(ReservaCNObserver::class);
        ReservaIO::observe(ReservaIOObserver::class);
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
