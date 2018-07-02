<?php

namespace App\Providers;

use App\Events\LicitacaoBBCreatedEvent;
use App\Events\LicitacaoCNCreatedEvent;
use App\Events\LicitacaoIOCreatedEvent;
use App\Events\ReservaBBCreatedEvent;
use App\Events\ReservaBBCreatedListener;
use App\Events\ReservaCNCreatedEvent;
use App\Events\ReservaCNCreatedListener;
use App\Events\ReservaIOCreatedEvent;
use App\Events\ReservaIOCreatedListener;
use App\Listeners\ProcessaLicitacaoBBListener;
use App\Listeners\ProcessaLicitacaoCNListener;
use App\Listeners\ProcessaLicitacaoIOListener;
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
            ProcessaLicitacaoBBListener::class
        ],

        LicitacaoCNCreatedEvent::class => [
            SendLicitacaoTelegramListener::class,
            ProcessaLicitacaoCNListener::class
        ],

        LicitacaoIOCreatedEvent::class => [
            SendLicitacaoTelegramListener::class,
            ProcessaLicitacaoIOListener::class
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
