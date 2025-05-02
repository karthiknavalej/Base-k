<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make {table} {class} {--section=} {--migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

    /**
     * Create a new command instance.
     *
     * @return void
    */
    public function __construct()
    {
        parent::__construct();
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
            ['class', 'm', InputOption::VALUE_REQUIRED],
        ];
    }

    // Override handle method
    public function handle()
    {
        // Init variables
        $table = $this->argument('table');
        $class = $this->argument('class');
        $section = $this->option('section');
        $migration = $this->option('migration');

        // Process variable
        $table = Str::of($table)->trim()->lower();
        $class = Str::of($class)->trim()->ucfirst();
        $section = Str::of($section)->trim()->ucfirst();
        $migration = Str::of($migration)->trim();


        if ($section != "" && !ctype_alpha((string) $section)) {
            $this->error('Please provide valid section name. eg: Admin, User, Business');
            return 1;
        }

        if ($migration) {
            $this->call('module:migration', ['table' => $table]);
        }

        // Level 0
        $this->call('module:model', ['name' => $class, 'table' => $table]);
        $this->call('module:seeder', ['name' => $class]);
        $this->call('module:policy', ['name' => $class]);

        // Level 1
        $this->call('module:controller', ['name' => $class, 'table' => $table, '--section' => $section]);
        $this->call('module:observer', ['name' => $class, '--section' => $section]);
        $this->call('module:resource', ['name' => $class, '--section' => $section]);
        
        // Level 2
        $this->call('module:interface', ['name' => $class, '--section' => $section]);
        $this->call('module:repository', ['name' => $class, '--section' => $section]);


        // Level 3
        $this->call('module:request-list', ['name' => $class,'--section' => $section]);
        $this->call('module:request-store', ['name' => $class,'table' => $table, '--section' => $section]);
        $this->call('module:request-update', ['name' => $class,'table' => $table, '--section' => $section]);
        $this->call('module:request-show', ['name' => $class, '--section' => $section]);
        $this->call('module:request-destroy', ['name' => $class, '--section' => $section]);

        // Base Setup
        $this->newLine();
        $this->info('Run this commands');
        $this->line('=================');
        $this->info('- php artisan migrate');
        $this->info('- php artisan db:seed --class='.$class.'Seeder');
        $this->info('- php artisan l5-swagger:generate');

        // Generating path
        $namespace = ($section != "") ? $section.'\\' : "";

        // Setup for Interface, Repository and Observer
        $this->newLine();
        $this->info('Setup - Interface, Repository and Observer');
        $this->line('==========================================');

        $loader = "['section' => '".$section."', 'name' => '".$class."'],";

        $this->info('- Add '.$loader.' in load() array in app/Providers/AppServiceProvider.php');
        $this->info('- Add '.$loader.' in load() array in app/Providers/ObserverServiceProvider.php');

        // Setup for Policies
        $this->newLine();
        $this->info('Setup - Policies');
        $this->line('================');

        $policy = "'App\Models\\".$class."' => 'App\Policies\\".$namespace.$class."Policy',";
        $this->info('- Add '.$policy.' in policies() array in app/Providers/AuthServiceProvider.php');

        // Setup for Route
        $this->newLine();
        $this->info('Setup - Route');
        $this->line('==============');

        $api = ($section != "") ? '/'.Str::of($section)->lower().'/'.$table : '/'.$table;
        
        $route = "Route::resource('".$api."','App\Http\Controllers\\".$namespace.$class."Controller');";
        $this->info("- Add ".$route." in routes/api.php");
        $this->newLine();
    }
}
