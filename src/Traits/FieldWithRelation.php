<?php

namespace Akibatech\Crud\Traits;

use Akibatech\Crud\Exceptions\InvalidRelationException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Validation\Validator;

/**
 * Class FieldWithRelation
 *
 * @package Akibatech\Crud\Traits
 */
trait FieldWithRelation
{
    /**
     * @var string $relation
     */
    protected $relation;

    /**
     * @var array
     */
    protected $options;

    /**
     * @param   string $relation
     * @return  self
     */
    public function withRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @param   void
     * @return  Relation
     */
    public function getRelation()
    {
        if (empty($this->relation))
        {
            throw new InvalidRelationException("{$this->getIdentifier()} does not contain any relation.");
        }

        $relation = $this->relation;

        return $this->getFields()->getEntry()->getModel()->$relation();
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        if (is_null($this->options))
        {
            $related = get_class($this->getRelation()->getRelated());
            $options = $related::get()->pluck('name', 'id')->toArray();
            
            $this->options = $options;
        }

        return $this->options;
    }

    /**
     * @param   Validator $validator
     * @return  Validator
     */
    public function beforeValidation(Validator $validator)
    {
        $related_class = $this->getRelation()->getRelated();
        $related_instance = new $related_class;
        $related_table = $related_class->getTable();
        $related_pk = $related_instance->getKeyName();

        $this->mergeRules($validator, "exists:$related_table,$related_pk");

        return $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableValue()
    {
        $relation = $this->relation;
        return $this->getFields()->getEntry()->getModel()->$relation->name;
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
