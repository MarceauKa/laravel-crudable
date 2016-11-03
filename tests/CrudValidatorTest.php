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
        $validator = new \Akibatech\Crud\Services\CrudValidator($this->model->crud());

        $this->assertInstanceOf(Akibatech\Crud\Services\CrudValidator::class, $validator);
        $this->assertEquals($validator->getEntry(), $this->model->crud());
    }

    /**
     * @test
     * @depends instance_creation
     */
    public function entry_returns_self_validator()
    {
        $validator = $this->model->crud()->getValidator();

        $this->assertInstanceOf(Akibatech\Crud\Services\CrudValidator::class, $validator);
        $this->assertEquals($validator->getEntry(), $this->model->crud());
    }

    /**
     * @test
     * @depends entry_returns_self_validator
     */
    public function passes_valid_data()
    {
        $validator = $this->model->crud()->validate([
            'title' => 'My title',
            'introduction' => 'My introduction',
            'content' => 'My content'
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
        $validator = $this->model->crud()->validate([
            'title' => 'My title',
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
        $this->model->crud()->validate([
            'title' => 'My title',
            'introduction' => 'My introduction',
            'content' => 'My content'
        ])->save();

        $this->assertEquals('My title', $this->model->crud()->getFields()->get('title')->getValue());
    }

    /**
     * @test
     * @depends hydrates_fields_on_correct_validation
     * @expectedException \Akibatech\Crud\Exceptions\FailedValidationException
     */
    public function throws_exception_when_trying_to_save_failed_validation()
    {
        $this->model->crud()->validate([
            'title' => 'My title',
        ])->save();
    }
}
