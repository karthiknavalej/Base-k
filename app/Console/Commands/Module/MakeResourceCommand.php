<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class MakeResourceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:resource {name} {--section=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource class';

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
        return app_path('Console/Stubs/Module/resource.stub');
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

        // Namespace variables
        $namespace = ($section != "") ? '\\'.$section : "";
        
        $stub = str_replace(['DummyNameSpace','DummyClassName'], [$namespace, $class], $stub);

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
        $path = 'Http/Resources/';

        // Init variables
        $name = $this->argument('name');
        $section = $this->option('section');
        
        // Process variable
        $class = Str::of($name)->trim()->ucfirst();
        $section = Str::of($section)->trim();

        // Generating path
        $section = ($section != "") ? $section.'/' : "";
        return $path . $section . $class . 'Resource';
    }
}
