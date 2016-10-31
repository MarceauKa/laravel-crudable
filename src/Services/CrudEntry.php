<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Fields\Field;
use Akibatech\Crud\Traits\Crudable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CrudEntry
 *
 * @package Akibatech\Crud\Services
 */
class CrudEntry
{
    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * @var Crudable|Model
     */
    protected $model;

    //-------------------------------------------------------------------------

    /**
     * CrudEntry constructor.
     *
     * @param   Crudable $model
     * @throws  \InvalidArgumentException
     */
    public function __construct(Model $model)
    {
        if (in_array(Crudable::class, class_uses($model)))
        {
            $this->model = $model;
            $this->fields = $model->getCrudFields();

            if (empty($this->fields))
            {
                throw new \RuntimeException("Given model has not crud fields.");
            }

            $this->hydrateFields();
        }
        else
        {
            throw new \InvalidArgumentException("The model must use Crudable trait.");
        }
    }

    //-------------------------------------------------------------------------

    /**
     * Get the entry's model.
     *
     * @param   void
     * @return  Crudable|Model
     */
    public function getModel()
    {
        return $this->model;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  \Generator
     */
    public function loopFields()
    {
        foreach ($this->fields as $field)
        {
            yield $field;
        }
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  self
     */
    protected function hydrateFields()
    {
        foreach ($this->fields as $field)
        {
            $field->setEntry($this);
        }

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    public function row()
    {
        $actions = [
            [
                'value' => 'Edit',
                'class' => 'btn btn-primary btn-xs',
                'uri'   => 'edit/' . $this->model->id
            ],
            [
                'value' => 'Delete',
                'class' => 'btn btn-danger btn-xs',
                'uri'   => 'delete/' . $this->model->id . '/' . csrf_token()
            ],
        ];

        $view = view()->make('crud::row')->with([
            'item' => $this->model,
            'fields' => $this->fields,
            'actions' => $actions
        ]);

        return $view->render();
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    public function form()
    {
        $view = view()->make('crud::form')->with([
            'entry' => $this
        ]);

        return $view->render();
    }
}
