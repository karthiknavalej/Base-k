<?php

namespace App\Console\Commands\Facade;

use Illuminate\Console\GeneratorCommand;

class MakeHelperClassCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:helper {filename} ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Helper class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Helper';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return 'app/Console/Stubs/Facade/helper.stub';
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
        return $rootNamespace . '\Facades\Helper';
    }



    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $filename)
    {
        $stub = str_replace(
            ['DummyNamespace'],
            [$this->getNamespace($filename)],
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
        return trim($this->argument('filename'));
    }
}
