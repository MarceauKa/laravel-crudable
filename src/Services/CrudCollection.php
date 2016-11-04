<?php

namespace Akibatech\Crud\Services;

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
     * @var null|CrudManager
     */
    protected $manager;

    /**
     * @var CrudFields
     */
    protected $fields;

    /**
     * CrudCollection constructor.
     *
     * @param   Crudable[] $items
     */
    public function __construct($items, $class)
    {
        parent::__construct($items);

        $class = empty($items) ? new $class : $this->first();

        $this->fields = $class->getCrudFields();
        $this->manager = $class->getCrudManager();
    }

    /**
     * @param   void
     * @return  CrudFields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param   void
     * @return  string
     */
    public function table()
    {
        $view = view()->make('crud::table')->with([
            'create_url' => $this->getManager()->getActionRoute('create'),
            'title'      => trans('crud::table.title', ['name' => $this->getManager()->getPluralizedName()]),
            'items'      => $this,
            'fields'     => $this->fields
        ]);

        return $view->render();
    }

    /**
     * @param   void
     * @return  CrudManager|null
     */
    public function getManager()
    {
        return $this->manager;
    }
}
