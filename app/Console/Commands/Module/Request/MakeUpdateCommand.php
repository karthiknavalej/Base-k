<?php

namespace App\Console\Commands\Module\Request;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class MakeUpdateCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:request-update {name} {table} {--section=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new update request class';

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
        return app_path('Console/Stubs/Module/Request/update.stub');
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
        // Init variables
        $class = Str::of($this->argument('name'))->trim()->ucfirst();
        $section = Str::of($this->option('section'))->trim();
        $action = Str::of($class)->lower();
        $table = $this->argument('table');

        // Namespace variables
        $namespace = ($section != "") ? '\\'.$section.'\\'.$class : '\\'.$class;
        
        $stub = str_replace(['DummyNameSpace','DummyClassName','DummyTableName','DummyActionName'], [$namespace, $class,$table, $action], $stub);

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
        $path = 'Http/Requests/';

        // Init variables
        $name = $this->argument('name');
        $section = $this->option('section');
        
        // Process variable
        $class = Str::of($name)->trim()->ucfirst();
        $section = Str::of($section)->trim();

        // Generating path
        $section = ($section != "") ? $section.'/' : "";
        return $path . $section . $class . '/UpdateRequest';
    }
}
