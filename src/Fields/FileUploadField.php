<?php

namespace Akibatech\Crud\Fields;

use Akibatech\Crud\Traits\FieldHandleUpload;
use Illuminate\Http\UploadedFile;

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
     * @var bool
     */
    protected $columnize = false;

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
        if ($file instanceof UploadedFile)
        {
            $value = $file->store($this->path, $this->disk);

            $this->fields->getEntry()->getModel()->setAttribute($this->getIdentifier(), $value);
        }

        return $this;
    }

    /**
     * @param   void
     * @return  string
     */
    public function getTableValue()
    {
        $value = $this->getValue();

        return empty($value) ? '' : sprintf('<a href="%s" target="_blank">%s</a>', url($value), basename($value));
    }
}
