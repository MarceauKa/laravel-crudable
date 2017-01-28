<?php

abstract class AbstractTestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->register(\Akibatech\Crud\CrudServiceProvider::class);

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    /**
     * Setup DB before each test.
     *
     * @return void  
     */
    public function setUp()
    { 
        parent::setUp();

        $this->app['config']->set('database.default','sqlite'); 
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        $this->migrate();
    }

    /**
     * Run package database tests migrations
     *
     * @return void
     */
    public function migrate()
    { 
        $fileSystem = new \Illuminate\Filesystem\Filesystem();
        $classFinder = new \Illuminate\Filesystem\ClassFinder();

        foreach($fileSystem->files(__DIR__ . '/Fixtures/database/migrations') as $file)
        {
            $fileSystem->requireOnce($file);
            $migrationClass = $classFinder->findClass($file);
            
            (new $migrationClass)->up();
        }

        DB::table('categories')->truncate();
        DB::table('categories')->insert([
            ['name' => 'PHP'],
            ['name' => 'Javascript'],
            ['name' => 'Linux'],
        ]);
    }
}
