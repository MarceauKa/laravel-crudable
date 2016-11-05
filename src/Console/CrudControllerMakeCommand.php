<?php

namespace Akibatech\Crud\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CrudControllerMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:crud:controller';

    /**
     * @var string
     */
    protected $description = 'Create a new crud friendly controller class';

    /**
     * @var string
     */
    protected $type = 'Controller';

    /**
     * @return  string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/controller.stub';
    }

    /**
     * @param   string  $rootNamespace
     * @return  string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Get and parse the model name.
     *
     * @param   void
     * @return  string
     */
    protected function getModelName()
    {
        $name = trim($this->argument('model'));
        $rootNamespace = $this->laravel->getNamespace();

        if (Str::contains($name, '/'))
        {
            $name = str_replace('/', '\\', $name);
        }

        if (Str::startsWith($name, $rootNamespace))
        {
            return '\\' . $name;
        }

        return '\\' . $rootNamespace . $name;
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), [
            ['model', InputArgument::REQUIRED, 'The name of the model, for example, "Post" or "App/Post"'],
        ]);
    }

    /**
     * @param   string  $name
     * @return  string
     */
    protected function buildClass($name)
    {
        $namespace = $this->getNamespace($name);

        $modelName = $this->getModelName();
        $modelClass = $modelName . '::class';

        $class = parent::buildClass($name);
        $class = str_replace("use {$namespace}\Controller;\n", '', $class);
        $class = str_replace('DummyModelClass', $modelClass, $class);
        $class = str_replace('DummyModel', $modelName, $class);

        return $class;
    }
}
