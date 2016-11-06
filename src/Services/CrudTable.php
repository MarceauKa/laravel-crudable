<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Traits\Crudable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

/**
 * Class CrudTable
 *
 * @package Akibatech\Crud\Services
 */
class CrudTable
{
    /**
     * @var CrudFields
     */
    protected $fields;

    /**
     * @var CrudManager
     */
    protected $manager;

    /**
     * @var Collection
     */
    protected $entries;

    /**
     * @var LengthAwarePaginator
     */
    protected $paginator;

    /**
     * @var string
     */
    protected $class;

    /**
     * CrudTable constructor.
     *
     * @param   Crudable|string
     */
    public function __construct($crudable)
    {
        if (is_string($crudable))
        {
            $this->class = $crudable;
            $crudable = new $crudable;
        }
        else
        {
            if (array_key_exists(Crudable::class, class_uses($crudable, true)))
            {
                $this->class = get_class($crudable);
            }
        }

        $this->fields = $crudable->getCrudFields();
        $this->manager = $crudable->getCrudManager();

        $this->hydrateEntries();
    }

    /**
     * @param   void
     * @return  self
     */
    protected function hydrateEntries()
    {
        $class = $this->class;

        $this->paginator = $class::latest()->paginate($this->manager->getPerPage());
        $this->entries = $this->paginator->getCollection();

        return $this;
    }

    /**
     * @param   void
     * @return  string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param   void
     * @return  string
     */
    public function table()
    {
        $view = View::make('crud::table')->with([
            'create_url' => $this->manager->getActionRoute('create'),
            'title'      => trans('crud::table.title', ['name' => $this->manager->getPluralizedName()]),
            'count'      => $this->paginator->total(),
            'is_empty'   => $this->paginator->total() === 0,
            'pagination' => $this->paginator,
            'entries'    => $this->entries->all(),
            'columns'    => $this->fields->columns()
        ]);

        return $view->render();
    }

    /**
     * @param   void
     * @return  string
     */
    public function __toString()
    {
        return $this->table();
    }
}
