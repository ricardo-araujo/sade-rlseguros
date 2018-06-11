<?php

namespace App\Providers;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HandlerForGuzzleProvider extends ServiceProvider
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
        $handlerStack = HandlerStack::create();
        $handlerStack->push(Middleware::retry($this->waitFunction()), 'retry');

        $this->app->instance(HandlerStack::class, $handlerStack);
    }

    private function waitFunction()
    {
        return function($retry, RequestInterface $request, ResponseInterface $response = null, RequestException $exception = null) {

            $shouldRetry = false;

            if ($retry >= 5)  //5 é o numero de tentativas do middleware, caso a requisicao apresente algum erro
                return false;

            if ($exception)
                $shouldRetry = true;

            if (!$response || $response->getStatusCode() >= 500)
                $shouldRetry = true;

            return $shouldRetry;
        };
    }
}
