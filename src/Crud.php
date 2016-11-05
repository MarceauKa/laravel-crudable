<?php

namespace Akibatech\Crud;

use Akibatech\Crud\Exceptions\InvalidArgumentException;
use Akibatech\Crud\Services\CrudEntry;
use Akibatech\Crud\Services\CrudTable;
use Akibatech\Crud\Traits\Crudable;

/**
 * Class Factory
 *
 * @package Akibatech\Crud\Services
 */
class Crud
{
    /**
     * @param   string|Crudable $crudable
     * @return  CrudTable
     * @throws  InvalidArgumentException
     */
    public static function table($crudable)
    {
        if (is_string($crudable))
        {
            return new CrudTable(new $crudable);
        }

        if (is_object($crudable) && array_key_exists(Crudable::class, class_uses($crudable)))
        {
            return new CrudTable($crudable);
        }

        throw new InvalidArgumentException("Argument must be Crudable.");
    }

    /**
     * @param   string|Crudable $crudable
     * @return  CrudEntry
     * @throws  InvalidArgumentException
     */
    public static function entry($crudable)
    {
        if (is_string($crudable))
        {
            return new CrudEntry(new $crudable);
        }
        else if (is_object($crudable) && array_key_exists(Crudable::class, class_uses($crudable)))
        {
            return new CrudEntry($crudable);
        }

        throw new InvalidArgumentException("Argument must be Crudable.");
    }
}
