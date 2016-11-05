<?php

namespace Akibatech\Crud\Traits;

use Akibatech\Crud\Crud;
use Akibatech\Crud\Services\CrudEntry;
use Akibatech\Crud\Services\CrudFields;
use Akibatech\Crud\Services\CrudManager;
use Akibatech\Crud\Services\CrudTable;

/**
 * Class Crudable
 *
 * @package Akibatech\Crud\Traits\Crudable
 */
trait Crudable
{
    /**
     * @var CrudEntry
     */
    protected $crud_entry;

    /**
     * @var CrudTable
     */
    protected $crud_table;

    /**
     * @param   void
     * @return  CrudEntry
     * @throws  \Akibatech\Crud\Exceptions\InvalidArgumentException
     */
    public function crudEntry()
    {
        if (is_null($this->crud_entry))
        {
            $this->crud_entry = Crud::entry($this);
        }

        return $this->crud_entry;
    }

    /**
     * @param   void
     * @return  CrudTable
     * @throws  \Akibatech\Crud\Exceptions\InvalidArgumentException
     */
    public function crudTable()
    {
        if (is_null($this->crud_table))
        {
            $this->crud_table = Crud::table($this);
        }

        return $this->crud_table;
    }

    /**
     * Returns model fields configuration.
     *
     * @param   void
     * @return  CrudFields
     */
    abstract public function getCrudFields();

    /**
     * Returns the CRUD configuration.
     *
     * @param   void
     * @return  CrudManager
     */
    abstract public function getCrudManager();

    /**
     * @param   void
     * @return  CrudManager
     */
    public static function crudRoutes()
    {
        return (new static)->getCrudManager()->registerRoutes();
    }
}
