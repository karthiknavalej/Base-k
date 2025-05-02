<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Load mapping array
     *
     * @return array
    */
    public function load()
    {
        return [
                [
                    'section' => '',
                    'name' => 'Auth'
                ],
                [
                    'section' => 'Admin',
                    'name' => 'Role'
                ],
                [
                    'section' => 'Admin',
                    'name' => 'Action'
                ],
                ['section' => 'Admin', 'name' => 'User'],
                ['section' => 'Admin', 'name' => 'Notification'],
                ['section' => 'Admin', 'name' => 'Message']
             ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $models = $this->load();
        foreach ($models as $model) {
            $interface = 'App\\Repositories\\';
            $repository = 'App\\Repositories\\';
            
            if ($model['section'] != "") {
                $interface .= $model['section'].'\\';
                $repository .= $model['section'].'\\';
            }

            $interface .= $model['name'] . '\\' . $model['name'] . 'RepositoryInterface';
            $repository .= $model['name'] . '\\' . $model['name'] . 'Repository';

            $this->app->bind($interface, $repository);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
