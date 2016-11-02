<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrudableModelTest extends AbstractTestCase
{
    /**
     * @var \TestModel\Post
     */
    protected $model;

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
    public function crudable_model_returns_crud_fields()
    {
        $this->assertInstanceOf('Akibatech\Crud\Services\CrudFields', $this->model->getCrudFields());
    }

    /**
     * @test
     */
    public function crudable_model_returns_crud_manager()
    {
        $this->assertInstanceOf('Akibatech\Crud\Services\CrudManager', $this->model->getCrudManager());
    }
}
