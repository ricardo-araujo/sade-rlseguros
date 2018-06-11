<?php

namespace App\Providers;

use App\Events\LicitacaoCreatedEvent;
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

        LicitacaoCreatedEvent::class => [
            SendLicitacaoTelegramListener::class
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
        //
    }
}
