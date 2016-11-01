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

    /**
     * @var CrudManager
     */
    protected $manager;

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
            $this->manager = $model->getCrudManager()->setEntry($this);
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
     * Get the entry ID.
     *
     * @param   void
     * @return  int|mixed
     */
    public function getId()
    {
        return $this->model->getAttribute($this->model->getKeyName());
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
                'uri'   => $this->manager->getActionRoute('edit')
            ],
            [
                'value' => trans('crud::buttons.destroy'),
                'class' => 'btn btn-danger btn-xs',
                'uri'   => $this->manager->getActionRoute('destroy')
            ],
        ];

        $view = view()->make('crud::row')->with([
            'entry'   => $this,
            'manager' => $this->manager,
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
        $is_new = !$this->getModel()->exist;
        $name = $this->getManager()->getName();
        $view_name = $is_new ? 'crud::form-update' : 'crud::form-create';

        $view = view()->make($view_name)->with([
            'title' => $is_new ? trans('crud::form.create_title', ['name' => $name]) : trans('crud::form.update_title', ['name' => $name]),
            'entry'   => $this,
            'manager' => $this->manager,
        ]);

        return $view->render();
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
     * @return  CrudManager
     */
    public function getManager()
    {
        return $this->manager;
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
