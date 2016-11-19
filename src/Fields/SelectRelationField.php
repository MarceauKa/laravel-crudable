<?php

namespace Akibatech\Crud\Fields;

use Akibatech\Crud\Traits\FieldWithRelation;

/**
 * Class SelectRelationField
 *
 * @package Akibatech\Crud\Fields
 */
class SelectRelationField extends Field
{
    use FieldWithRelation;

    /**
     * @var string
     */
    const TYPE = 'select-relation';

    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.select-relation';
    }
}
