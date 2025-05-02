<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Load observer array
     *
     * @return array
    */
    public function load()
    {
        return [
            [
                'section' => 'Admin',
                'name' => 'Role'
            ],
            [
                'section' => 'Admin',
                'name' => 'Action'
            ],
            ['section' => 'Admin', 'name' => 'User'],
         ];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $models = $this->load();
        foreach ($models as $model) {
            $interface = 'App\\Repositories\\';
            $observer = 'App\\Observers\\';
            
            if ($model['section'] != "") {
                $interface .= $model['section'].'\\';
                $observer .= $model['section'].'\\';
            }

            $interface .= $model['name'] . '\\' . $model['name'] . 'RepositoryInterface';
            $observer .= $model['name'] . 'Observer';

            app($interface)->observe($observer);
        }
    }
}
