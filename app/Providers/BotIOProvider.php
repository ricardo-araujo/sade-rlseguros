<?php

namespace App\Providers;

use Forseti\Bot\IO\PageObject\LicitacaoDetalhesPageObject;
use Forseti\Bot\IO\PageObject\LicitacaoDownloadEditalPageObject;
use Forseti\Bot\IO\PageObject\LicitacaoPageObject;
use Forseti\Bot\IO\PageObject\RenderizaBoletimPageObject;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\ServiceProvider;

class BotIOProvider extends ServiceProvider
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
        $this->app->singleton(LicitacaoPageObject::class, function() {

            return new LicitacaoPageObject(new Client([
                'handler' => app(HandlerStack::class),
                'cookies' => true,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                ],
                'timeout' => 10,
                'connect_timeout' => 10,
            ]));

        });

        $this->app->singleton(LicitacaoDetalhesPageObject::class, function() {

            return new LicitacaoDetalhesPageObject(new Client([
                'handler' => app(HandlerStack::class),
                'cookies' => true,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                ],
                'timeout' => 10,
                'connect_timeout' => 10,
            ]));

        });

        $this->app->singleton(LicitacaoDownloadEditalPageObject::class, function() {

            return new LicitacaoDownloadEditalPageObject(new Client([
                'handler' => app(HandlerStack::class),
                'cookies' => true,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                ],
                'timeout' => 10,
                'connect_timeout' => 10,
            ]));

        });

        $this->app->singleton(RenderizaBoletimPageObject::class, function () {

            return new RenderizaBoletimPageObject(new Client([
                'handler' => app(HandlerStack::class),
                'cookies' => true,
                'verify' => false,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                ],
                'timeout' => 10,
                'connect_timeout' => 10,
            ]));

        });
    }
}
