<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Zend\Mail\Storage\Imap;

class ZendMailProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Imap::class, function () {

            $imapbox = new Imap([
                'host' => env('MAIL_IO_HOST'),
                'user' => env('MAIL_IO_USER'),
                'password' => env('MAIL_IO_PASSWORD'),
            ]);

            return $imapbox;
        });
    }

    public function provides()
    {
        return [Imap::class];
    }
}
