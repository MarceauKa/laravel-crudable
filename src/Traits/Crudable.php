<?php

namespace Akibatech\Crud\Traits;

use Akibatech\Crud\Services\CrudCollection;
use Akibatech\Crud\Services\CrudEntry;

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
    protected $crud;

    //-------------------------------------------------------------------------

    /**
     * Initialize if not exists and returns the CrudManager for the model.
     *
     * @param   void
     * @return  CrudEntry
     */
    public function crud()
    {
        if (is_null($this->crud))
        {
            $this->crud = new CrudEntry($this);
        }

        return $this->crud;
    }

    //-------------------------------------------------------------------------

    /**
     * Returns model fields configuration.
     *
     * @param   void
     * @return  array
     */
    abstract public function getCrudFields();

    //-------------------------------------------------------------------------

    /**
     * Create a new CrudCollection instance.
     *
     * @param  Crudable[]  $models
     * @return CrudCollection
     */
    public function newCollection(array $models = [])
    {
        if (method_exists($this, 'newCrudCollection'))
        {
            return $this->newCrudCollection($models);
        }

        return new CrudCollection($models);
    }
}
