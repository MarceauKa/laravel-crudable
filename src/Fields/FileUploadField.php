<?php

namespace Akibatech\Crud\Fields;

use Akibatech\Crud\Traits\FieldHandleUpload;

/**
 * Class FileUploadField
 *
 * @package Akibatech\Crud\Fields
 */
class FileUploadField extends Field
{
    use FieldHandleUpload;
    
    /**
     * @var string
     */
    const TYPE = 'fileupload';

    /**
     * @var string
     */
    const MULTIPART = true;

    /**
     * @inheritdoc
     */
    public function getViewName()
    {
        return 'crud::fields.fileupload';
    }

    /**
     * @param   mixed $file
     * @return  self
     */
    public function newValue($file)
    {
        $value = $file->store($this->path, $this->disk);

        $this->fields->getEntry()->getModel()->setAttribute($this->getIdentifier(), $value);
    }

    /**
     * @param   void
     * @return  string
     */
    public function getTableValue()
    {
        return '<a href="'.url($this->getValue()).'">'.basename($this->getValue()).'</a>';
    }
}
