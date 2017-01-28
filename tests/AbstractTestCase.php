<?php

abstract class AbstractTestCase extends \Illuminate\Foundation\Testing\TestCase
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

        $app['config']->set('database.default','sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
        $dir = __DIR__ . '/Fixtures/';
        $app->useDatabasePath($dir);

        return $app;
    }

    /**
     * @return  void
     */
    public function refreshApplication()
    {
        $this->app = $this->createApplication();
    }
}
