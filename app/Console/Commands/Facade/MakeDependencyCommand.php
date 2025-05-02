<?php

namespace App\Console\Commands\Facade;

use Illuminate\Console\GeneratorCommand;

class MakeDependencyCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:facade {facadeName} ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new facade class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Dependency';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return 'app/Console/Stubs/Facade/dependency.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Facades\Dependency';
    }


    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $facadeName)
    {
        $stub = str_replace(
            ['DummyNamespace','BindingVariable'],
            [$this->getNamespace($facadeName),$this->argument('facadeName')],
            $stub
        );

        return $this;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('facadeName') . 'Facade');
    }

    // Override handle method
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }
        $this->call('make:helper', ['filename' => trim($this->argument('facadeName'))]);
    }
}
