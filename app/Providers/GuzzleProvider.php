<?php

namespace App\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\ServiceProvider;

class GuzzleProvider extends ServiceProvider
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
        $this->app->bind(ClientInterface::class, function ($app, array $params = []) {

            $config = array_collapse([$params, [
                'handler' => app()->make(HandlerStack::class), //provider de Handler de retry, fiz o provider para nao poluir essa classe
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36'
                ]
            ]]);

            return new Client($config);

        });
    }
}
