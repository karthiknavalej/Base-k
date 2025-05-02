<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class MakeModelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:model {name} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return app_path('Console/Stubs/Module/model.stub');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['name', 'n', InputOption::VALUE_REQUIRED],
            ['table', 'n', InputOption::VALUE_REQUIRED],
        ];
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        // Declare variable
        $class = Str::of($this->argument('name'))->trim()->ucfirst();
        $table = Str::of($this->argument('table'))->trim();

        $stub = str_replace(['DummyClassName','DummyTableName'], [$class,$table], $stub);

        return $this;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        // Init path
        $path = 'Models/';

        // Init variables
        $name = Str::of($this->argument('name'))->trim()->ucfirst();

        // Generating path
        return $path . $name;
    }
}
