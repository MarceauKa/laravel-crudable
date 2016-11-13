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
            'draft' => 'Draft',
            'live' => 'Live'
        ], $this->field->getOptions());
    }

    /**
     * @test
     */
    public function it_verify_its_options()
    {
        $this->assertTrue($this->field->hasOption('live'));
        $this->assertFalse($this->field->hasOption('foo'));
    }

    /**
     * @test
     */
    public function it_returns_its_options_keys()
    {
        $this->assertEquals(['draft', 'live'], $this->field->getOptionsKeys());
    }

    /**
     * @test
     */
    public function it_returns_an_option_value()
    {
        $this->assertEquals('Live', $this->field->getOption('live'));
    }

    /**
     * @test
     */
    public function it_registers_its_own_rule()
    {
        $this->assertContains('in:draft,live', $this->field->getRules());
    }

    /**
     * @test
     */
    public function it_returns_the_correct_table_value()
    {
        $this->assertNull($this->field->getTableValue());
        $this->field->newValue('live');
        $this->assertEquals('Live', $this->field->getTableValue());
    }

    /**
     * @test
     */
    public function it_saves_the_default_value_when_empty()
    {
        try {
            $this->entry->save();
        } catch (\Illuminate\Database\QueryException $e) {
            unset($e);
        }

        $this->assertEquals('live', $this->field->getValue());
    }

    /**
     * @test
     */
    public function it_not_saves_the_default_value_when_not_empty()
    {
        $this->field->newValue('draft');

        try {
            $this->entry->save();
        } catch (\Illuminate\Database\QueryException $e) {
            unset($e);
        }

        $this->assertNotEquals('live', $this->field->getValue());
        $this->assertEquals('draft', $this->field->getValue());
    }
}
