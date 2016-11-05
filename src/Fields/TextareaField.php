<?php

namespace Akibatech\Crud\Fields;

/**
 * Class TextareaField
 *
 * @package Akibatech\Crud\Fields
 */
class TextareaField extends Field
{
    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getTableValue()
    {
        return str_limit($this->getValue(), 40);
    }
}
