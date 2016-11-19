<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FieldWithRelationTest extends AbstractTestCase
{
    /**
     * @var \TestModel\Post
     */
    protected $model;

    /**
     * @var \Akibatech\Crud\Services\CrudEntry
     */
    protected $entry;

    /**
     * @param   void
     * @return  void
     */
    public function setUp()
    {
        parent::setUp();

        $this->model = new \TestModel\Post();
        $this->entry = $this->model->crudEntry();
        $this->field = $this->entry->getFields()->get('category_id');
    }

    /**
     * @test
     */
    public function it_returns_its_options()
    {
        $this->assertEquals([
            '1' => 'PHP',
            '2' => 'Javascript',
            '3' => 'Linux'
        ], $this->field->getOptions());
    }

    /**
     * @test
     */
    public function is_displays_correct_relation_value()
    {
        $this->entry->getFields()->get('category_id')->newValue(1);
        $this->assertEquals('PHP', $this->field->getTableValue());
    }
}
