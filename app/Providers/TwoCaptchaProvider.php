<?php

namespace App\Providers;

use Forseti\Crawler\NoRecaptcha\TwoCaptcha\AutenticacaoTwoCaptcha;
use Forseti\Crawler\NoRecaptcha\TwoCaptcha\TwoCaptchaWithGoogleKey;
use Illuminate\Support\ServiceProvider;

class TwoCaptchaProvider extends ServiceProvider
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
        $this->app->singleton(TwoCaptchaWithGoogleKey::class, function() {

            $twoCaptcha = new TwoCaptchaWithGoogleKey(new AutenticacaoTwoCaptcha(env('2CAPTCHA_KEY')));
            $twoCaptcha->processaGoogleKey(env('GOOGLE_RECAPTCHA_KEY'), env('MAPFRE_URL'));

            return $twoCaptcha;
        });
    }
}
