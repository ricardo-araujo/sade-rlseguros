<?php

namespace App\Providers;

use Forseti\Bot\IO\Seguro\Crawler\Form;
use Forseti\Bot\IO\Seguro\Crawler\ParseListaLicitacao;
use Illuminate\Support\ServiceProvider;

class ParseListaLicitacaoProvider extends ServiceProvider
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
        $this->app->singleton(ParseListaLicitacao::class, function() {

            $page = new Form();

            $page->setDateIni(today('America/Sao_Paulo'));

            $page->setDateFim(today('America/Sao_Paulo')->addYears(1));

            $html = $page->getHtml();

            return new ParseListaLicitacao($html);
        });
    }
}
