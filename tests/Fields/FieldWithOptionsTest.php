<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FieldWithOptionsTest extends AbstractTestCase
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
     * @var \Akibatech\Crud\Fields\RadioField
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
        $this->field = $this->entry->getFields()->get('status');
    }

    /**
     * @test
     */
    public function it_returns_its_options()
    {
        $this->assertEquals([
            0 => 'Draft',
            1 => 'Live'
        ], $this->field->getOptions());
    }

    /**
     * @test
     */
    public function it_verify_its_options()
    {
        $this->assertTrue($this->field->hasOption(0));
        $this->assertFalse($this->field->hasOption(2));
    }

    /**
     * @test
     */
    public function it_returns_its_options_keys()
    {
        $this->assertEquals([0, 1], $this->field->getOptionsKeys());
    }

    /**
     * @test
     */
    public function it_returns_an_option_value()
    {
        $this->assertEquals('Live', $this->field->getOption(1));
    }

    /**
     * @test
     */
    public function it_registers_its_own_rule()
    {
        $this->assertContains('in:0,1', $this->field->getRules());
    }

    /**
     * @test
     */
    public function it_returns_the_correct_table_value()
    {
        $this->assertNull($this->field->getTableValue());
        $this->field->newValue(1);
        $this->assertEquals('Live', $this->field->getTableValue());
    }
}
