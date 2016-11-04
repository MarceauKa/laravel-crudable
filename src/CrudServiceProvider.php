<?php

namespace Akibatech\Crud;

use Illuminate\Support\ServiceProvider;

/**
 * Class CrudServiceProvider
 *
 * @package Akibatech\Crud
 */
class CrudServiceProvider extends ServiceProvider
{
    /**
     * @param   void
     * @return  void
     */
    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            $this->publishes([
                __DIR__ . '/../resources/lang/' => resource_path('lang/vendor/crud'),
            ], 'crud');

            $this->publishes([
                __DIR__ . '/../resources/views/' => resource_path('views/vendor/crud'),
            ], 'crud');
        }

        if ($this->app->runningUnitTests())
        {
            $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'crud');
            $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'crud');
        }
        else
        {
            $this->loadViewsFrom(resource_path('views/vendor/crud'), 'crud');
            $this->loadTranslationsFrom(resource_path('lang/vendor/crud'), 'crud');
        }
    }

    /**
     * @param   void
     * @return  void
     */
    public function register()
    {

    }
}
