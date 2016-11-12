<?php

namespace Akibatech\Crud\Traits;
use Illuminate\Http\UploadedFile;

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
        $this->disk =  $disk;

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

        $this->addRule('mimes:' . $types);

        return $this;
    }

    /**
     * @param   int $size
     * @return  self
     */
    public function withMaxSize($size = 2048)
    {
        $this->max_size = $size;

        $this->addRule('max:'.$size);

        return $this;
    }
}
