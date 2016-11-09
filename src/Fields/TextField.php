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
     * @var string
     */
    const TYPE = 'text';

    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.text';
    }
}
