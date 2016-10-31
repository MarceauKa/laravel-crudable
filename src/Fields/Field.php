<?php

namespace Akibatech\Crud\Fields;

use Akibatech\Crud\Services\CrudEntry;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Field
 *
 * @package Akibatech\Crud\Fields
 */
abstract class Field
{
    /**
     * @var CrudEntry $entry
     */
    protected $entry;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $label;

    //-------------------------------------------------------------------------

    /**
     * Field constructor.
     *
     * @param   string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   Model $model
     * @return  $this
     */
    public function setEntry(CrudEntry $entry)
    {
        $this->entry = $entry;

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  mixed
     */
    public function getValue()
    {
        return $this->entry->getModel()->getAttributeValue($this->key);
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $name
     * @return  self
     */
    public function widthLabel($name)
    {
        $this->label = $name;

        return $this;
    }

    //-------------------------------------------------------------------------

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
            return title_case($this->key);
        }

        return $this->label;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    abstract public function getViewName();

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    public function form()
    {
        $view = view()->make($this->getViewName())->with([
            'field' => $this
        ]);

        return $view->render();
    }
}
