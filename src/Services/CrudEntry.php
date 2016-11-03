<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Exceptions\InvalidModelException;
use Akibatech\Crud\Exceptions\NoFieldsException;
use Akibatech\Crud\Fields\Field;
use Akibatech\Crud\Traits\Crudable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class CrudEntry
 *
 * @package Akibatech\Crud\Services
 */
class CrudEntry
{
    /**
     * @var CrudFields
     */
    protected $fields = [];

    /**
     * @var Crudable|Model
     */
    protected $model;

    /**
     * @var CrudManager
     */
    protected $manager;

    /**
     * @var CrudValidator
     */
    protected $validator;

    /**
     * CrudEntry constructor.
     *
     * @param   Model|Crudable $model
     * @throws  \InvalidArgumentException
     */
    public function __construct(Model $model)
    {
        if (in_array(Crudable::class, class_uses($model)))
        {
            $this->model = $model;
            $this->manager = $model->getCrudManager()->setEntry($this);
            $this->fields = $model->getCrudFields()->setEntry($this);

            if ($this->fields->count() === 0)
            {
                throw new NoFieldsException(get_class($model) . ' has no fields.');
            }
        }
        else
        {
            throw new InvalidModelException("The model must use Crudable trait.");
        }
    }

    /**
     * @param   void
     * @return  \Generator
     */
    public function fields()
    {
        foreach ($this->fields->loop() as $field)
        {
            yield $field;
        }
    }

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

    /**
     * @param   void
     * @return  string
     */
    public function form()
    {
        $is_new = !$this->getModel()->exists;
        $name = $this->getManager()->getName();

        $with = [
            'back_url' => $this->manager->getActionRoute('index'),
            'entry'    => $this,
            'manager'  => $this->manager,
        ];

        if ($is_new)
        {
            $view_name = 'crud::form-create';
            $method = $this->manager->getActionMethod('store');

            $with += [
                'title'        => trans('crud::form.create_title', ['name' => $name]),
                'form_url'     => $this->manager->getActionRoute('store'),
                'form_method'  => $method,
                'csrf_field'   => csrf_token(),
                'method_field' => method_field($method),
            ];
        }
        else
        {
            $view_name = 'crud::form-update';
            $method = $this->manager->getActionMethod('update');

            $with += [
                'title'        => trans('crud::form.update_title', ['name' => $name]),
                'form_url'     => $this->manager->getActionRoute('update'),
                'form_method'  => $method,
                'csrf_field'   => csrf_token(),
                'method_field' => method_field($method),
            ];
        }

        $view = view()->make($view_name)->with($with);

        return $view->render();
    }

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

    /**
     * @param   void
     * @return  CrudManager
     */
    public function getManager()
    {
        return $this->manager;
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
     * Resets the validator.
     *
     * @param   void
     * @return  self
     */
    public function resetValidator()
    {
        $this->validator = null;

        return $this;
    }

    /**
     * Shortcut to self validate.
     *
     * @param   array $data
     * @return  self
     */
    public function validate(array $data)
    {
        return $this->getValidator()->validate($data);
    }

    /**
     * Gets the validator.
     *
     * @param   void
     * @return  CrudValidator
     */
    public function getValidator()
    {
        if (is_null($this->validator))
        {
            $this->validator = new CrudValidator($this);
        }

        return $this->validator;
    }

    /**
     * Saves the model.
     *
     * @param   void
     * @return  bool
     */
    public function save()
    {
        return $this->model->save();
    }

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
