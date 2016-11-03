<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Exceptions\DuplicateFieldIdentifierException;
use Akibatech\Crud\Exceptions\NoFieldsException;
use Akibatech\Crud\Fields\Field;

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
     * @param   string $identifier
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
     * @return  array
     */
    public function keys()
    {
        return array_keys($this->fields);
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
}
