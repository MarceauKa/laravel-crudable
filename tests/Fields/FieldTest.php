<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FieldTest extends AbstractTestCase
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
     * @var \Akibatech\Crud\Fields\TextField
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
        $this->field = $this->entry->getFields()->get('title');
    }

    /**
     * @test
     */
    public function field_returns_its_identifier()
    {
        $this->assertEquals('title', $this->field->getIdentifier());
    }

    /**
     * @test
     */
    public function field_returns_its_label()
    {
        $this->assertEquals('Title', $this->field->getLabel());
        $this->field->withLabel('My label');
        $this->assertEquals('My label', $this->field->getLabel());
    }

    /**
     * @test
     */
    public function field_returns_its_placeholder()
    {
        $this->assertEquals('Title of the post', $this->field->getPlaceholder());
        $this->field->withPlaceholder('Foo');
        $this->assertEquals('Foo', $this->field->getPlaceholder());
    }

    /**
     * @test
     */
    public function field_returns_its_help()
    {
        $this->assertNull($this->field->getHelp());
        $this->field->withHelp('This is the help');
        $this->assertEquals('This is the help', $this->field->getHelp());
    }

    /**
     * @test
     */
    public function field_returns_its_forms()
    {
        $this->field->withLabel('Foo label')->withHelp('Foo help')->withPlaceholder('Strange placeholder');
        $form = $this->field->form();

        $this->assertContains('Foo label', $form);
        $this->assertContains('Foo help', $form);
        $this->assertContains('Strange placeholder', $form);
    }

    /**
     * @test
     */
    public function field_returns_its_assets()
    {
        $this->field = $this->entry->getFields()->get('content');

        $this->assertContains('tinymce.init', $this->field->form());
    }
}
