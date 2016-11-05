<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrudTest extends AbstractTestCase
{
    /**
     * @test
     * @expectedException \Akibatech\Crud\Exceptions\InvalidArgumentException
     */
    public function it_throws_an_exception_when_calling_table_from_lambda()
    {
        \Akibatech\Crud\Crud::table(new stdClass());
    }

    /**
     * @test
     * @expectedException \Akibatech\Crud\Exceptions\InvalidArgumentException
     */
    public function it_throws_an_exception_when_calling_entry_from_lambda()
    {
        \Akibatech\Crud\Crud::entry(new stdClass());
    }

    /**
     * @test
     */
    public function it_returns_entry_from_string()
    {
        $this->assertInstanceOf(\Akibatech\Crud\Services\CrudEntry::class, \Akibatech\Crud\Crud::entry('\TestModel\Post'));
    }

    /**
     * @test
     */
    public function it_returns_table_from_string()
    {
        $this->assertInstanceOf(\Akibatech\Crud\Services\CrudTable::class, \Akibatech\Crud\Crud::table('\TestModel\Post'));
    }

    /**
     * @test
     * @depends it_returns_entry_from_string
     */
    public function it_returns_entry_from_instance()
    {
        $this->assertInstanceOf(\Akibatech\Crud\Services\CrudEntry::class, \Akibatech\Crud\Crud::entry(new \TestModel\Post()));
    }

    /**
     * @test
     * @depends it_returns_table_from_string
     */
    public function it_returns_table_from_instance()
    {
        $this->assertInstanceOf(\Akibatech\Crud\Services\CrudTable::class, \Akibatech\Crud\Crud::table(new \TestModel\Post()));
    }
}
