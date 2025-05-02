<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class MakeMigrationCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:migration {table : Table name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration class';

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
        return app_path('Console/Stubs/Module/migration.stub');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
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
        // Declare variable
        $table = Str::of($this->argument('table'))->trim();
        $class = Str::of($table)->ucfirst();

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
        $path = '../database/migrations/';

        // Declare variable
        $table = Str::of($this->argument('table'))->trim()->lower();

        $file = date('Y_m_d_His').'_create_'.$table.'_table';
        return $path.$file;
    }
}
