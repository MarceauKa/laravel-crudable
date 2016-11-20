<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatePickerFieldTest extends AbstractTestCase
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
     * @var \Akibatech\Crud\Fields\DatePickerField
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
        $this->field = $this->entry->getFields()->get('published_at');
    }

    /**
     * @test
     */
    public function it_returns_valid_js_format()
    {
        $this->assertEquals('yyyy-mm-dd', \Akibatech\Crud\Fields\DatePickerField::dateFormatJs('Y-m-d'));
        $this->assertEquals('dd/mm/yy', \Akibatech\Crud\Fields\DatePickerField::dateFormatJs('d/m/y'));
        $this->assertEquals('DD d MM yyyy', \Akibatech\Crud\Fields\DatePickerField::dateFormatJs('l j F Y'));
    }

    /**
     * @test
     */
    public function it_returns_its_options_variables()
    {
        $format  = 'Y-m-d';
        $options = $this->field->getViewVariables();

        $this->assertEquals([
            'date_format' => \Akibatech\Crud\Fields\DatePickerField::dateFormatJs($format),
            'date_min'    => \Carbon\Carbon::now()->format($format),
            'date_max'    => null,
            'date_locale' => false
        ], $options);
    }

    /**
     * @test
     */
    public function it_validates_valid_data()
    {
        $validation = $this->entry->validate(['published_at' => \Carbon\Carbon::now()->format('Y-m-d')]);

        $this->assertArrayNotHasKey('published_at', $validation->getValidator()->failed());

    }

    /**
     * @test
     */
    public function it_not_validates_invalid_data()
    {
        $validation = $this->entry->validate(['published_at' => \Carbon\Carbon::now()->subDays(2)->format('Y-m-d')]);

        $this->assertArrayHasKey('published_at', $validation->getValidator()->failed());
        $this->assertArrayHasKey('After', $validation->getValidator()->failed()['published_at']);

    }
}
