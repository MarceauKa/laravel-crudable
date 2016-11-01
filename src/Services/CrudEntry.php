<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Exceptions\InvalidModelException;
use Akibatech\Crud\Exceptions\NoFieldsException;
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
    public $fields = [];

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
            $this->fields = clone $model->getCrudFields();

            if ($this->fields->count() === 0)
            {
                throw new NoFieldsException(get_class($model) . ' has no fields.');
            }

            $this->hydrateFields();
        }
        else
        {
            throw new InvalidModelException("The model must use Crudable trait.");
        }
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  self
     */
    public function hydrateFields()
    {
        foreach ($this->fields as &$field)
        {
            $field->setEntry($this);
        }

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  \Generator
     */
    public function fields()
    {
        foreach ($this->fields->loop() as $field)
        {
            yield $field->setEntry($this);
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
     * @return  string
     */
    public function row()
    {
        $actions = [
            [
                'value' => trans('crud::buttons.edit'),
                'class' => 'btn btn-primary btn-xs',
                'uri'   => 'edit/' . $this->model->id
            ],
            [
                'value' => trans('crud::buttons.delete'),
                'class' => 'btn btn-danger btn-xs',
                'uri'   => 'delete/' . $this->model->id . '/' . csrf_token()
            ],
        ];

        $view = view()->make('crud::row')->with([
            'entry' => $this,
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

    //-------------------------------------------------------------------------

    /**
     * @param   string $name
     * @return  Field|null
     */
    public function __get($name)
    {
        if ($this->fields->has($name))
        {
            return $this->fields->get($name)->setEntry($this);
        }

        return null;
    }
}
