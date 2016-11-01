<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Exceptions\DuplicateFieldIdentifierException;
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

    //-------------------------------------------------------------------------

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

    //-------------------------------------------------------------------------

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

        $this->fields[$identifier] = $field;

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  int
     */
    public function count()
    {
        return count($this->fields);
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $identifier
     * @return  bool
     */
    public function has($identifier)
    {
        return array_key_exists($identifier, $this->fields) === true;
    }

    //-------------------------------------------------------------------------

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

    //-------------------------------------------------------------------------

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

    //-------------------------------------------------------------------------

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

    //-------------------------------------------------------------------------
}
