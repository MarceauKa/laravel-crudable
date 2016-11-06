<?php

namespace Akibatech\Crud\Traits;

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
     * @param   array $options
     * @return  self
     */
    public function withOptions($options = [])
    {
        $this->options = $options;

        $this->addRule('in:' . implode(',', array_keys($this->getOptionsKeys())));

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
     * @return  string|null
     */
    public function getTableValue()
    {
        return $this->getOption($this->getValue());
    }
}
