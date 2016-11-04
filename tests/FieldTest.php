<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FieldTest extends AbstractTestCase
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
     * @var \Akibatech\Crud\Fields\TextField
     */
    protected $title;

    /**
     * @param   void
     * @return  void
     */
    public function setUp()
    {
        parent::setUp();

        $this->model = new \TestModel\Post();
        $this->entry = $this->model->crud();
        $this->title = $this->entry->getFields()->get('title');
    }

    /**
     * @test
     */
    public function field_returns_its_identifier()
    {
        $this->assertEquals('title', $this->title->getIdentifier());
    }

    /**
     * @test
     */
    public function field_returns_its_label()
    {
        $this->assertEquals('Title', $this->title->getLabel());
        $this->title->withLabel('My label');
        $this->assertEquals('My label', $this->title->getLabel());
    }

    /**
     * @test
     */
    public function field_returns_its_placeholder()
    {
        $this->assertEquals('Title of the post', $this->title->getPlaceholder());
        $this->title->withPlaceholder('Foo');
        $this->assertEquals('Foo', $this->title->getPlaceholder());
    }

    /**
     * @test
     */
    public function field_returns_its_help()
    {
        $this->assertNull($this->title->getHelp());
        $this->title->withHelp('This is the help');
        $this->assertEquals('This is the help', $this->title->getHelp());
    }

    /**
     * @test
     */
    public function field_returns_its_forms()
    {
        $this->title->withLabel('Foo label')->withHelp('Foo help')->withPlaceholder('Strange placeholder');
        $form = $this->title->form();

        $this->assertContains('Foo label', $form);
        $this->assertContains('Foo help', $form);
        $this->assertContains('Strange placeholder', $form);
    }
}
