<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Imunew\JWTAuth\Providers\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

/**
 * Class TestCase
 * @package Tests
 */
class TestCase extends BaseTestCase
{
    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('jwt.refresh_ttl', 20160);
        $app['config']->set('jwt-auth.cookie.key', 'test-auth-token');
        $app['config']->set('jwt-auth.auth-headers.enabled', true);

        $app->register(ServiceProvider::class);
        $app->register(LaravelServiceProvider::class);
    }
}
