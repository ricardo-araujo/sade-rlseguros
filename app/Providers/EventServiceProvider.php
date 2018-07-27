<?php

namespace App\Providers;

use App\Events\LicitacaoBBCreatedEvent;
use App\Events\LicitacaoCNCreatedEvent;
use App\Events\LicitacaoIOCreatedEvent;
use App\Events\ReservaBBCreatedEvent;
use App\Events\ReservaCNCreatedEvent;
use App\Events\ReservaIOCreatedEvent;
use App\Listeners\LicitacaoBBCreatedListener;
use App\Listeners\LicitacaoCNCreatedListener;
use App\Listeners\LicitacaoIOCreatedListener;
use App\Listeners\ReservaBBCreatedListener;
use App\Listeners\ReservaCNCreatedListener;
use App\Listeners\ReservaIOCreatedListener;
use App\Listeners\SendLicitacaoTelegramListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        LicitacaoBBCreatedEvent::class => [
            SendLicitacaoTelegramListener::class,
            LicitacaoBBCreatedListener::class
        ],

        LicitacaoCNCreatedEvent::class => [
            SendLicitacaoTelegramListener::class,
            LicitacaoCNCreatedListener::class
        ],

        LicitacaoIOCreatedEvent::class => [
            SendLicitacaoTelegramListener::class,
            LicitacaoIOCreatedListener::class
        ],

        ReservaBBCreatedEvent::class => [
            ReservaBBCreatedListener::class
        ],

        ReservaCNCreatedEvent::class => [
            ReservaCNCreatedListener::class
        ],

        ReservaIOCreatedEvent::class => [
            ReservaIOCreatedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
