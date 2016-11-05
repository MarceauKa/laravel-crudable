<?php

namespace Akibatech\Crud;

use Illuminate\Support\Facades\Facade;

/**
 * Class Factory
 *
 * @package Akibatech\Crud
 */
class CrudFacade extends Facade
{
    /**
     * @return  string
     */
    protected static function getFacadeAccessor()
    {
        return 'crud';
    }
}
