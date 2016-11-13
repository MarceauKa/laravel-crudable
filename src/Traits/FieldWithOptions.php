<?php

namespace Akibatech\Crud\Traits;
use Akibatech\Crud\Exceptions\InvalidModelException;

/**
 * Class FieldWithOptions
 *
 * @package Akibatech\Crud\Traits
 */
trait FieldWithOptions
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var mixed
     */
    protected $default_option = null;

    /**
     * @param   array $options
     * @param   mixed $default The default value. It's a key from given options.
     * @return  self
     */
    public function withOptions($options = [], $default = null)
    {
        $this->options = $options;

        $this->addRule('in:' . implode(',', $this->getOptionsKeys()));

        if (!is_null($default))
        {
            if (!array_key_exists($default, $options))
            {
                throw new InvalidModelException("$default option does not exist in given options.");
            }

            $this->default_option = $default;
        }

        return $this;
    }

    /**
     * @param   mixed $identifier
     * @return  bool
     */
    public function hasOption($identifier)
    {
        return array_key_exists($identifier, $this->getOptions());
    }

    /**
     * @param   void
     * @return  array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param   void
     * @return  array
     */
    public function getOptionsKeys()
    {
        return array_keys($this->options);
    }

    /**
     * @param   void
     * @return  string|null
     */
    public function getOption($identifier)
    {
        return $this->hasOption($identifier) ? $this->options[$identifier] : null;
    }

    /**
     * @param   void
     * @return  mixed
     */
    public function getDefaultOption()
    {
        return $this->default_option;
    }

    /**
     * @param   void
     * @return  string|null
     */
    public function getTableValue()
    {
        return $this->getOption($this->getValue());
    }

    /**
     * @param   void
     * @return  self
     */
    public function beforeSave()
    {
        if (is_null($this->getValue()) && !is_null($this->default_option))
        {
            $this->newValue($this->default_option);
        }

        return $this;
    }
}
