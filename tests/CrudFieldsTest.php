<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrudFieldsTest extends AbstractTestCase
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
        $this->fields = $this->model->getCrudFields();
    }

    /**
     * @test
     */
    public function returns_the_number_of_configured_fields()
    {
        $this->assertEquals(3, $this->fields->count());
    }

    /**
     * @test
     */
    public function accepts_a_new_field()
    {
        $this->fields->set(new \Akibatech\Crud\Fields\TextareaField('foo'));
        $this->assertEquals(true, $this->fields->has('foo'));
    }

    /**
     * @test
     */
    public function accepts_many_new_fields_at_once()
    {
        $this->fields->add([
            new \Akibatech\Crud\Fields\TextareaField('foo'),
            new \Akibatech\Crud\Fields\TextareaField('bar')
        ]);

        $this->assertTrue($this->fields->has('foo'));
        $this->assertTrue($this->fields->has('bar'));
        $this->assertFalse($this->fields->has('baz'));
    }

    /**
     * @test
     * @expectedException \Akibatech\Crud\Exceptions\DuplicateFieldIdentifierException
     */
    public function throws_an_exception_when_adding_many_fields_with_the_same_identifier()
    {
        $this->fields->add([
            new \Akibatech\Crud\Fields\TextField('title'),
            new \Akibatech\Crud\Fields\TextField('title')
        ]);
    }

    /**
     * @test
     */
    public function returns_a_field_when_calling_it_with_its_identifier()
    {
        $field = $this->fields->get('title');

        $this->assertInstanceOf(Akibatech\Crud\Fields\TextField::class, $field);
    }

    /**
     * @test
     */
    public function returns_all_field_when_trying_to_get_without_identifier()
    {
        $fields = $this->fields->get();

        $this->assertTrue(is_array($fields));
        $this->assertEquals(3, count($fields));
    }

    /**
     * @test
     */
    public function returns_null_when_getting_an_unknow_identifier()
    {
        $field = $this->fields->get('qux');

        $this->assertNull($field);
    }

    /**
     * @test
     */
    public function fields_loop_returns_all_fields()
    {
        $fields = [];

        foreach ($this->fields->loop() as $field)
        {
            $fields[] = $field;
        }

        $this->assertEquals(3, count($fields));
    }

    /**
     * @test
     */
    public function fields_columns_returns_exact_labels()
    {
        $labels = [];

        foreach ($this->fields->columns() as $label)
        {
            $labels[] = $label;
        }

        $this->assertEquals('Title', $labels[0]);
        $this->assertEquals('Introduction', $labels[1]);
        $this->assertEquals('Content', $labels[2]);
    }
}
