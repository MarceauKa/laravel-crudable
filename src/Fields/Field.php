<?php

namespace Akibatech\Crud\Fields;

use Akibatech\Crud\Services\CrudFields;
use Akibatech\Crud\Traits\FieldHasUiModifiers;
use Illuminate\Validation\Validator;
use Illuminate\View\View;

/**
 * Class Field
 *
 * @package Akibatech\Crud\Fields
 */
abstract class Field
{
    use FieldHasUiModifiers;

    /**
     * @var string
     */
    const TYPE = 'type';

    /**
     * @var bool
     */
    const MULTIPART = false;

    /**
     * @var CrudFields
     */
    protected $fields;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var array
     */
    protected $rules;

    /**
     * Field constructor.
     *
     * @param   string       $identifier
     * @param   array|string $rules
     */
    public function __construct($identifier, $rules = null)
    {
        $this->identifier = $identifier;

        if (!is_null($rules))
        {
            $this->withRules($rules);
        }
    }

    /**
     * Constructs staticly.
     *
     * @param   string $idenfitier
     * @param   null|string|array $rules
     * @return  static
     */
    public static function handle($idenfitier, $rules = null)
    {
        return (new static($idenfitier, $rules));
    }


    /**
     * Add validation rules to the field.
     *
     * @param   string|array $rules
     * @return  mixed
     */
    public function withRules($rules)
    {
        if (is_array($rules))
        {
            foreach ($rules as $rule)
            {
                $this->addRule($rule);
            }
        }
        else
        {
            if (is_string($rules))
            {
                if (stripos($rules, '|') !== false)
                {
                    $rules = explode('|', $rules);

                    return $this->withRules($rules);
                }

                return $this->withRules([$rules]);
            }
        }

        return $this;
    }

    /**
     * Add a validation rule.
     *
     * @param   string $rule
     * @return  self
     */
    public function addRule($rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * @param   CrudFields $fields
     * @return  self
     */
    public function setFields(CrudFields $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get the field identifier.
     *
     * @param   void
     * @return  string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Render the field form.
     *
     * @param   void
     * @return  string
     */
    public function form()
    {
        return $this->getForm()->render();
    }

    /**
     * Get the form view.
     *
     * @param   void
     * @return  View
     */
    protected function getForm()
    {
        return view()->make($this->getViewName())->with($this->getViewBaseVariables());
    }

    /**
     * Get the field view name.
     *
     * @param   void
     * @return  string
     */
    abstract public function getViewName();

    /**
     * Returns additionnal variables to the views.
     *
     * @param   void
     * @return  array
     */
    protected function getViewVariables()
    {
        return [];
    }

    /**
     * Returns all base variables for the view.
     *
     * @param   void
     * @return  array
     */
    protected function getViewBaseVariables()
    {
        $base_variables = [
            'field'       => $this,
            'has_error'   => $this->hasError(),
            'error'       => $this->getError(),
            'placeholder' => $this->getPlaceholder(),
            'help'        => $this->getHelp(),
            'has_old'     => $this->hasOld(),
            'old'         => $this->getOld(),
            'label'       => $this->getLabel(),
            'name'        => $this->identifier,
            'id'          => 'field-' . $this->identifier,
            'value'       => $this->getValue()
        ];

        return array_merge($base_variables, $this->getViewVariables());
    }

    /**
     * Checks if the field has an error.
     *
     * @param   void
     * @return  bool
     */
    public function hasError()
    {
        return $this->fields->getErrors()->has($this->identifier);
    }

    /**
     * Returns the error.
     *
     * @param   void
     * @return  null|string
     */
    public function getError()
    {
        if ($this->hasError())
        {
            return $this->fields->getErrors()->first($this->identifier);
        }

        return null;
    }

    /**
     * Checks if the field has a previous value.
     *
     * @param   void
     * @return  bool
     */
    public function hasOld()
    {
        return $this->fields->getOldInput()->has($this->identifier);
    }

    /**
     * Returns the old value.
     *
     * @param   void
     * @return  string|null
     */
    public function getOld()
    {
        if ($this->hasOld())
        {
            return $this->fields->getOldInput()->first($this->identifier);
        }

        return null;
    }

    /**
     * Get the field value.
     *
     * @param   void
     * @return  mixed
     */
    public function getValue()
    {
        if ($this->fields->getEntry())
        {
            return $this->fields->getEntry()->getModel()->getAttributeValue($this->identifier);
        }

        return null;
    }

    /**
     * Get the value to be displayed on a table.
     *
     * @param   void
     * @return  mixed
     */
    public function getTableValue()
    {
        return $this->getValue();
    }

    /**
     * Set a new value to the model.
     *
     * @param   mixed $value
     * @return  self
     */
    public function newValue($value)
    {
        if ($value != $this->getValue())
        {
            $this->fields->getEntry()->getModel()->setAttribute($this->identifier, $value);
        }

        return $this;
    }

    /**
     * @param   void
     * @return  string
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param   Validator $validator
     * @return  Validator
     */
    public function beforeValidation(Validator $validator)
    {
        return $validator;
    }

    /**
     * @param   void
     * @return  self
     */
    public function beforeSave()
    {
        return $this;
    }
}
