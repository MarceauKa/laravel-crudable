<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Fields\Field;
use Akibatech\Crud\Traits\Crudable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CrudCollection
 *
 * @package Akibatech\Crud\Services
 */
class CrudCollection extends Collection
{
    /**
     * @var Field[]
     */
    protected $fields = [];

    //-------------------------------------------------------------------------

    /**
     * CrudCollection constructor.
     *
     * @param   Crudable[] $items
     */
    public function __construct($items)
    {
        parent::__construct($items);

        $this->fields = $this->first()->getCrudFields();
    }

    //-------------------------------------------------------------------------

    /**
     *
     */
    public function table()
    {
        $view = view()->make('crud::table')->with(['items' => $this, 'fields' => $this->fields]);

        return $view->render();
    }
}
