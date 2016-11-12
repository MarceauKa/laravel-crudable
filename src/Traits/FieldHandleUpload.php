<?php

namespace Akibatech\Crud\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator;

/**
 * Class FieldHandleUpload
 *
 * @package Akibatech\Crud\Traits
 */
trait FieldHandleUpload
{
    /**
     * @var string
     */
    protected $disk = 'public';

    /**
     * @var string
     */
    protected $path = 'uploads';

    /**
     * @var string
     */
    protected $mimes;

    /**
     * @var int
     */
    protected $max_size;

    /**
     * @param   string $disk
     * @return  self
     */
    public function uploadToDisk($disk = 'public')
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * @param   string $path
     * @return  self
     */
    public function uploadToPath($path = 'uploads')
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param   string $types
     * @return  self
     */
    public function withTypes($types)
    {
        $this->mimes = $types;

        return $this;
    }

    /**
     * @param   int $size
     * @return  self
     */
    public function withMaxSize($size = 2048)
    {
        $this->max_size = $size;

        return $this;
    }

    /**
     * @param   Validator $validator
     * @return  Validator
     */
    public function beforeValidation(Validator $validator)
    {
        $rules = [];
        $identifier = $this->getIdentifier();

        if ($this->mimes)
        {
            $rules[] = 'mimes:' . $this->mimes;
        }

        if ($this->max_size)
        {
            $rules[] = 'max:' . $this->max_size;
        }

        if (count($rules) > 0)
        {
            $validator->sometimes($this->getIdentifier(), $rules, function ($input) use ($identifier)
            {
                return is_null($input->{$identifier}) ? false : true;
            });
        }

        return $validator;
    }
}
