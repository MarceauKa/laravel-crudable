<?php

namespace Akibatech\Crud\Fields;

use Akibatech\Crud\Traits\FieldWithOptions;

/**
 * Class RadioField
 *
 * @package Akibatech\Crud\Fields
 */
class RadioField extends Field
{
    use FieldWithOptions;

    /**
     * @var string
     */
    const TYPE = 'radio';

    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.radio';
    }

    /**
     * {@inheritdoc}
     */
    public function getViewVariables()
    {
        return [
            'options' => $this->getOptions(),
        ];
    }
}
