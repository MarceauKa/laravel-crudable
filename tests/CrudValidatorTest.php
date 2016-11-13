<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrudValidatorTest extends AbstractTestCase
{
    /**
     * @var \TestModel\Post
     */
    protected $model;

    /**
     * @var \Akibatech\Crud\Services\CrudFields
     */
    protected $fields;

    /**
     * @param   void
     * @return  void
     */
    public function setUp()
    {
        parent::setUp();

        $this->model = new \TestModel\Post();
    }

    /**
     * @test
     */
    public function instance_creation()
    {
        $validator = new \Akibatech\Crud\Services\CrudValidator($this->model->crudEntry());

        $this->assertInstanceOf(Akibatech\Crud\Services\CrudValidator::class, $validator);
        $this->assertEquals($validator->getEntry(), $this->model->crudEntry());
    }

    /**
     * @test
     * @depends instance_creation
     */
    public function entry_returns_self_validator()
    {
        $validator = $this->model->crudEntry()->getValidator();

        $this->assertInstanceOf(Akibatech\Crud\Services\CrudValidator::class, $validator);
        $this->assertEquals($validator->getEntry(), $this->model->crudEntry());
    }

    /**
     * @test
     * @depends entry_returns_self_validator
     */
    public function passes_valid_data()
    {
        $validator = $this->model->crudEntry()->validate([
            'title'        => 'My title',
            'introduction' => 'My introduction',
            'content'      => 'My content',
            'status'       => 'live',
            'illustration' => $this->getMockedUploadedFile()
        ]);

        $this->assertTrue($validator->passes());
        $this->assertFalse($validator->fails());
    }

    /**
     * @test
     * @depends passes_valid_data
     */
    public function fails_invalid_data()
    {
        $validator = $this->model->crudEntry()->validate([
            'title'        => 'My title',
            'introduction' => 'My intro',
            'content'      => 'My content',
            'status'       => 'draft',
            // Error here
            'illustration' => $this->getMockedUploadedFile(['guessExtension' => 'pdf'])
        ]);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->fails());
    }

    /**
     * @test
     * @depends fails_invalid_data
     */
    public function hydrates_fields_on_correct_validation()
    {
        $this->model->crudEntry()->validate([
            'title'        => 'My title',
            'introduction' => 'My introduction',
            'content'      => 'My content',
            'status'       => 'draft',
            'illustration' => $this->getMockedUploadedFile()
        ])->save();

        $this->assertEquals('My title', $this->model->crudEntry()->getFields()->get('title')->getValue());
        $this->assertEquals('123.jpeg', $this->model->crudEntry()->getFields()->get('illustration')->getValue());
    }

    /**
     * @test
     * @depends hydrates_fields_on_correct_validation
     * @expectedException \Akibatech\Crud\Exceptions\FailedValidationException
     */
    public function throws_exception_when_trying_to_save_failed_validation()
    {
        $this->model->crudEntry()->validate([
            'title' => 'My title',
        ])->save();
    }

    /**
     * @param   array $options
     * @return  \Mockery\MockInterface
     */
    private function getMockedUploadedFile($options = [])
    {
        return Mockery::mock('\Illuminate\Http\UploadedFile',
            array_merge([
                'store'          => '123.jpeg',
                'isValid'        => true,
                'getPath'        => '/',
                'guessExtension' => 'jpeg',
                'getSize'        => 2048
            ], $options));
    }
}
