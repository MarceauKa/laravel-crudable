<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FieldHandleUploadText extends AbstractTestCase
{
    use DatabaseMigrations;

    /**
     * @var \TestModel\Post
     */
    protected $model;

    /**
     * @var \Akibatech\Crud\Services\CrudEntry
     */
    protected $entry;

    /**
     * @var \Akibatech\Crud\Fields\FileUploadField
     */
    protected $field;

    /**
     * @param   void
     * @return  void
     */
    public function setUp()
    {
        parent::setUp();

        $this->model = new \TestModel\Post();
        $this->entry = $this->model->crudEntry();
        $this->field = $this->entry->getFields()->get('illustration');
    }

    /**
     * @test
     */
    public function it_handles_new_value_from_uploaded_file()
    {
        $file = Mockery::mock(
            '\Illuminate\Http\UploadedFile',
            [
                'store' => 'uploads/123.jpeg'
            ]
        );

        $this->field->newValue($file);

        $this->assertEquals('uploads/123.jpeg', $this->field->getValue());
    }
}
