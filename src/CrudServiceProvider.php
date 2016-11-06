<?php

namespace Akibatech\Crud;

use Akibatech\Crud\Console\CrudControllerMakeCommand;
use Illuminate\Support\Facades\Blade;
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
            $this->commands([
                CrudControllerMakeCommand::class
            ]);

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

        Blade::directive('crudtable', function($expression) {
            return "<?php echo crud_table($expression); ?>";
        });

        Blade::directive('crudentry', function($expression) {
            return "<?php echo crud_entry($expression); ?>";
        });
    }

    /**
     * @param   void
     * @return  void
     */
    public function register()
    {
        $this->app->bind('Akibatech\Crud\Crud', Crud::class);
        $this->app->alias('Akibatech\Crud\Crud', 'crud');

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Crud', 'Akibatech\Crud\CrudFacade');
    }
}
