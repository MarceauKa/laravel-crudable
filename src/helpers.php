<?php

if (function_exists('crud') === false)
{
    /**
     * @see     \Akibatech\Crud\Crud
     * @param   \Akibatech\Crud\Traits\Crudable|string
     * @return  \Akibatech\Crud\Services\CrudTable
     * @throws  \Akibatech\Crud\Exceptions\InvalidArgumentException
     */
    function crud_table($crudable)
    {
        return \Akibatech\Crud\Crud::table($crudable);
    }

    /**
     * @see     \Akibatech\Crud\Crud
     * @param   \Akibatech\Crud\Traits\Crudable|string
     * @return  \Akibatech\Crud\Services\CrudEntry
     * @throws  \Akibatech\Crud\Exceptions\InvalidArgumentException
     */
    function crud_entry($crudable)
    {
        return \Akibatech\Crud\Crud::table($crudable);
    }
}
