<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Exceptions\DuplicateFieldIdentifierException;
use Akibatech\Crud\Exceptions\NoFieldsException;
use Akibatech\Crud\Fields\Field;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

/**
 * Class CrudFields
 *
 * @package Akibatech\Crud\Services
 */
class CrudFields
{
    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * @var CrudEntry
     */
    protected $entry;

    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * @var MessageBag
     */
    protected $old_input;

    /**
     * @var bool
     */
    protected $multipart = false;

    /**
     * Make staticly a new instance.
     *
     * @param   array $fields
     * @return  CrudFields
     */
    public static function make(array $fields)
    {
        return (new static)->add($fields);
    }

    /**
     * @param   CrudEntry $entry
     * @return  self
     */
    public function setEntry(CrudEntry $entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * @param   void
     * @return  CrudEntry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param   Field[] $fields
     * @return  self
     * @throws  DuplicateFieldIdentifierException
     */
    public function add(array $fields)
    {
        if (is_array($fields) && count($fields) > 0)
        {
            /** @var Field $field */
            foreach ($fields as $field)
            {
                $this->set($field);
            }
        }

        return $this;
    }

    /**
     * @param   Field $field
     * @return  self
     * @throws  DuplicateFieldIdentifierException
     */
    public function set(Field $field)
    {
        $identifier = $field->getIdentifier();

        if ($this->has($identifier))
        {
            throw new DuplicateFieldIdentifierException("$identifier was already set.");
        }

        $field->setFields($this);
        $this->fields[$identifier] = $field;

        return $this;
    }

    /**
     * @param   void
     * @return  int
     */
    public function count()
    {
        return count($this->fields);
    }

    /**
     * @param   string $identifier
     * @return  bool
     */
    public function has($identifier)
    {
        return array_key_exists($identifier, $this->fields) === true;
    }

    /**
     * @param   null|string $identifier
     * @return  Field[]|Field|null
     */
    public function get($identifier = null)
    {
        if (is_null($identifier))
        {
            return $this->fields;
        }

        if ($this->has($identifier))
        {
            return $this->fields[$identifier];
        }

        return null;
    }

    /**
     * @param   void
     * @return  \Generator
     */
    public function columns()
    {
        foreach ($this->fields as $field)
        {
            yield $field->getLabel();
        }
    }

    /**
     * @param   void
     * @return  \Generator
     */
    public function loop()
    {
        foreach ($this->fields as $field)
        {
            yield $field;
        }
    }

    /**
     * Returns all fields keys.
     *
     * @param   void
     * @return  integer[]
     */
    public function keys()
    {
        return array_keys($this->fields);
    }

    /**
     * @param   void
     * @return  array
     */
    public function getFieldsScripts()
    {
        $scripts = [];

        foreach ($this->fields as $field)
        {
            $scripts = array_merge($scripts, $field->getScripts());
        }

        return $scripts;
    }

    /**
     * @param   void
     * @return  array
     */
    public function getFieldsCss()
    {
        $css = [];

        foreach ($this->fields as $field)
        {
            $css = array_merge($css, $field->getCss());
        }

        return $css;
    }

    /**
     * Gets fields validation rules.
     *
     * @param   void
     * @return  array
     * @throws  NoFieldsException
     */
    public function validationRules()
    {
        $rules = [];

        if ($this->count() === 0)
        {
            throw new NoFieldsException();
        }

        foreach ($this->fields as $key => $field)
        {
            $field_rules = $field->getRules();

            if (!empty($field_rules))
            {
                $rules[$key] = $field_rules;
            }
        }

        return $rules;
    }

    /**
     * @param   Validator $validator
     * @return  Validator
     */
    public function contextualValidationRules(Validator $validator)
    {
        foreach ($this->fields as &$field)
        {
            $validator = $field->beforeValidation($validator);
        }

        return $validator;
    }

    /**
     * Hydrate fields with new data.
     *
     * @param   array $data
     * @return  self
     */
    public function hydrateFormData(array $data)
    {
        if (count($data) === 0)
        {
            return $this;
        }

        foreach ($this->fields as $field)
        {
            if (array_key_exists($field->getIdentifier(), $data))
            {
                $field->newValue($data[$field->getIdentifier()]);
            }
        }

        return $this;
    }

    /**
     * @param   void
     * @return  MessageBag
     */
    public function getErrors()
    {
        if (is_null($this->errors))
        {
            $this->errors = new MessageBag();
        }

        return $this->errors;
    }

    /**
     * @param   void
     * @return  MessageBag
     */
    public function getOldInput()
    {
        if (is_null($this->old_input))
        {
            $this->old_input = new MessageBag();
        }

        return $this->old_input;
    }

    /**
     * @param   void
     * @return  bool
     */
    public function getMultipart()
    {
        foreach ($this->fields as $field)
        {
            if ($field::MULTIPART === true)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Hydrates the instance with previous validation errors.
     *
     * @param   MessageBag $errors
     * @return  self
     */
    public function hydrateErrorsFromSession(MessageBag $errors = null)
    {
        if (!is_null($errors))
        {
            $this->errors = $errors;
            return $this;
        }

        $request = app()->make('request');

        if ($request->session()->has('errors'))
        {
            $this->errors = $request->session()->get('errors', MessageBag::class);
        }

        return $this;
    }

    /**
     * Hydrates the instance with previous input.
     *
     * @param   MessageBag $old_input
     * @return  self
     */
    public function hydrateFieldsFromSession(MessageBag $old_input = null)
    {
        if (!is_null($old_input))
        {
            $this->old_input = $old_input;
            return $this;
        }

        $request = app()->make('request');

        if ($request->session()->has('_old_input'))
        {
            $this->old_input = new MessageBag($request->old());
        }

        return $this;
    }
}
