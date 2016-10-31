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
        $this->loadViewsFrom(__DIR__.'/../views', 'crud');
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  void
     */
    public function register()
    {

    }
}
