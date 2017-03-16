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
          return new Repository($config, new Rewrite(), $app['path.config']);
        });
    }
}
