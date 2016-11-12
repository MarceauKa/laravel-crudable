<?php

namespace Akibatech\Crud\Traits;

/**
 * Class FieldHasUiModifiers
 *
 * @package Akibatech\Crud\Traits
 */
trait FieldHasUiModifiers
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $placeholder;

    /**
     * @var string
     */
    protected $help;

    /**
     * Displayed or not the field in the columns.
     *
     * @var bool
     */
    protected $columnize = true;

    /**
     * Set a custom label for the field.
     *
     * @param   string $name
     * @return  self
     */
    public function withLabel($name)
    {
        $this->label = $name;

        return $this;
    }

    /**
     * Defines a placeholder for the field.
     *
     * @param   string $placeholder
     * @return  self
     */
    public function withPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Appends an help message to the input.
     *
     * @param   string $help
     * @return  self
     */
    public function withHelp($help)
    {
        $this->help = $help;

        return $this;
    }

    /**
     * Returns the field's label.
     *
     * @param   void
     * @return  string
     */
    public function getLabel()
    {
        if (empty($this->label))
        {
            return title_case($this->identifier);
        }

        return $this->label;
    }

    /**
     * Returns the field's placeholder.
     *
     * @param   void
     * @return  string
     */
    public function getPlaceholder()
    {
        if (empty($this->placeholder))
        {
            return null;
        }

        return $this->placeholder;
    }

    /**
     * Returns the field's help.
     *
     * @param   void
     * @return  string
     */
    public function getHelp()
    {
        if (empty($this->help))
        {
            return null;
        }

        return $this->help;
    }

    /**
     * @param   bool $state
     * @return  self
     */
    public function displayInColumns($state = true)
    {
        $this->columnize = $state;

        return $this;
    }

    /**
     * @param   void
     * @return  bool
     */
    public function isDisplayedInColumns()
    {
        return $this->columnize === true;
    }

    /**
     * Return fields specific scripts files from public folder.
     * Example: ['js/field.js']
     *
     * @param   void
     * @return  array
     */
    public function getScripts()
    {
        return [];
    }

    /**
     * Return fields specific stylesheets files from public folder.
     * Example: ['css/field.css']
     *
     * @param   void
     * @return  array
     */
    public function getCss()
    {
        return [];
    }
}
