<?php

namespace Akibatech\Crud\Fields;

/**
 * Class EmailField
 *
 * @package Akibatech\Crud\Fields
 */
class EmailField extends Field
{
    /**
     * EmailField constructor.
     *
     * {@inheritdoc}
     */
    public function __construct($identifier, $rules)
    {
        parent::__construct($identifier, $rules);

        $this->addRule('email');
    }

    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.email';
    }
}
