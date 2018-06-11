<?php

namespace App\Providers;

use Forseti\Bot\CN\PageObject\ConsultaLicitacoes\ConsLicitacaoRelacaoPage;
use Forseti\Bot\CN\PageObject\ConsultaLicitacoes\DownloadPage;
use Forseti\Bot\CN\PageObject\ConsultaLicitacoes\PesquisarUasgPage;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class BotCNProvider extends ServiceProvider
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
        $this->app->singleton(ConsLicitacaoRelacaoPage::class, function(Application $app) {

            $http = new Client([
                'handler' => app()->make(HandlerStack::class),
                'verify' => false,
                'cookies' => true,
                'timeout' => 60,
                'connect_timeout' => 10,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.110 Safari/537.36',
                ]
            ]);

            return new ConsLicitacaoRelacaoPage($http);
        });

        $this->app->singleton(DownloadPage::class, function(Application $app) {

            $http = $http = new Client([
                'handler' => app()->make(HandlerStack::class),
                'verify' => false,
                'cookies' => true,
                'timeout' => 60,
                'connect_timeout' => 10,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.110 Safari/537.36',
                ]
            ]);

            $forsetiService = new \ForsetiCaptcha\Client([
                'accesstoken' => env('FORSETI_CAPTCHA_CN')
            ]);

            return new DownloadPage($http, $forsetiService);
        });

        $this->app->singleton(PesquisarUasgPage::class, function(Application $app) {

            $http = $http = new Client([
                'handler' => app()->make(HandlerStack::class),
                'verify' => false,
                'cookies' => true,
                'timeout' => 60,
                'connect_timeout' => 10,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.110 Safari/537.36',
                ]
            ]);

            return new PesquisarUasgPage($http);
        });
    }
}
