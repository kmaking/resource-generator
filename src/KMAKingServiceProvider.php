<?php

namespace KMAKing\ResourceGenerator;

use Illuminate\Support\ServiceProvider;
use KMAKing\ResourceGenerator\Commands\{
    ResourceGenerator,
    ViewGenerator,
    ControllerGenerator, 
    UrlPresenterGenerator
};

class KMAKingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                ResourceGenerator::class,
                ViewGenerator::class,
                ControllerGenerator::class,
                UrlPresenterGenerator::class,
            ]);
            
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
