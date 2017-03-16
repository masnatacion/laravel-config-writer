<?php

namespace SergeyMiracle\Config;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = app('config')->all();

        $this->app->singleton('config', function ($app) use ($config) {
            $writer = new FileWriter($app['files'], $app['path.config']);

            return new Repository($config, $writer);
        });
    }
}
