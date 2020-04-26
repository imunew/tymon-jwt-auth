<?php

namespace Imunew\JWTAuth\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Tymon\JWTAuth\Http\Parser\AuthHeaders;
use Tymon\JWTAuth\Http\Parser\Cookies;
use Tymon\JWTAuth\Http\Parser\Parser;

/**
 * Class ServiceProvider
 * @package Imunew\JWTAuth\Providers
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->resetParserChain();
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * @return void
     */
    private function resetParserChain()
    {
        $this->app->extend('tymon.jwt.parser', function (Parser $parser) {
            $chain = [
                (new Cookies(config('jwt.decrypt_cookies')))
                    ->setKey(config('jwt-auth.cookie.key'))
            ];
            if (config('jwt-auth.auth-headers.enabled')) {
                $chain[] = new AuthHeaders();
            }
            return $parser->setChain($chain);
        });
    }

    /**
     * @return void
     */
    private function publishConfig()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('jwt-auth.php')], 'config');
        $this->mergeConfigFrom($path, 'jwt-auth');
    }
}
