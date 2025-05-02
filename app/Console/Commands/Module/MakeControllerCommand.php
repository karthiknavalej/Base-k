<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class MakeControllerCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:controller {name} {table} {--section=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

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
        return app_path('Console/Stubs/Module/controller.stub');
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
            ['table', 't', InputOption::VALUE_REQUIRED],
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
        $class = $this->argument('name');
        $table = $this->argument('table');
        $section = $this->option('section');

        // Root
        $namespace = "";
        $api = '/'.$table;
        $tag = Str::of($table)->ucfirst();
        
        // Section
        if ($section != "") {
            $namespace = '\\'.$section;
            $api = '/'.Str::of($section)->lower().'/'.$table;
            $tag = $section.' - '.Str::of($table)->ucfirst();
        }
        
        $stub = str_replace(['DummyNameSpace','DummyClassName','DummyApiName','DummySectionName','DummyTagName'], [$namespace, $class, $api, $section,$tag], $stub);

        return $this;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        // Init Controllers path
        $path = 'Http/Controllers/';

        // Init variables
        $name = $this->argument('name');
        $section = $this->option('section');
        
        // Process variable
        $name = Str::of($name)->trim()->ucfirst();
        $section = Str::of($section)->trim();

        // Generating path
        $section = ($section != "") ? $section.'/' : "";
        return $path . $section . $name . 'Controller';
    }
}
