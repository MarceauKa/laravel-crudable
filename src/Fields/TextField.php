<?php

namespace Akibatech\Crud\Fields;

/**
 * Class TextField
 *
 * @package Akibatech\Crud\Fields
 */
class TextField extends Field
{
    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.text';
    }
}
