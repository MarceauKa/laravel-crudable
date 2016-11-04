<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CrudCollectionTest extends AbstractTestCase
{
    /**
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected $db;

    /**
     * @param   void
     * @return  void
     */
    public function setUp()
    {
        parent::setUp();

        $this->router = $this->app->make('Illuminate\Routing\Router');
        $this->db = $this->app->make('Illuminate\Database\Connection');

        \TestModel\Post::crudRoutes();
    }

    /**
     * @test
     */
    public function its_register_routes()
    {
        \TestModel\Post::crudRoutes();

        $this->assertTrue($this->router->has('posts.index'));
        $this->assertTrue($this->router->has('posts.create'));
    }

    /**
     * @test
     * @depends its_register_routes
     */
    public function its_returns_empty_table_when_empty_collection()
    {
        $this->db->table('posts')->delete();
        $table = \TestModel\Post::all()->table();

        $this->assertContains('Posts list', $table);
        $this->assertContains('No entries', $table);
    }

    /**
     * @test
     * @depends its_returns_empty_table_when_empty_collection
     */
    public function its_returns_table_with_on_entry()
    {
        $this->db->table('posts')->delete();
        $this->db->table('posts')->insert([
            'title' => 'My title',
            'introduction' => 'My introduction',
            'content' => 'My content'
        ]);

        $table = \TestModel\Post::all()->table();

        $this->assertContains('Posts list', $table);
        $this->assertContains('My title', $table);
    }
}
