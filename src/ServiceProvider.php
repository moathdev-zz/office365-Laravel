<?php

namespace Moathdev\Office365;


use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Office365::class, function (Container $app) {
            return new Office365($app);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $source = realpath(__DIR__ . '/../config/Office365.php');
        $this->publishes([$source => config_path('Office365.php')]);
        $this->mergeConfigFrom($source, 'Office365');
    }
}