<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Load helpers array
     *
     * @return array
    */
    public function load()
    {
        return [
            [
                'name' => 'SendMail',
                'value' => 'SendMail'
            ],
            [
                'name' => 'Excel',
                'value' => 'Excel'
            ]
        ];
    }

    public function register()
    {
        $classes = $this->load();
        foreach ($classes as $class) {
            $value = $class['value'];
            $this->app->bind($class['name'], function () use ($value) {
                $classPath = 'App\\Facades\\Helper\\'.$value;
                return new $classPath();
            });
        }
    }
}
