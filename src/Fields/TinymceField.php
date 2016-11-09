<?php

namespace Akibatech\Crud\Fields;

/**
 * Class TinymceField
 *
 * @package Akibatech\Crud\Fields
 */
class TinymceField extends Field
{
    /**
     * @var string
     */
    const TYPE = 'tinymce';

    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.tinymce';
    }

    /**
     * {@inheritdoc}
     */
    public function getTableValue()
    {
        return str_limit(strip_tags($this->getValue()), 40);
    }

    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return [
            'vendor/crud/fields/tinymce/tinymce.min.js',
        ];
    }
}
