<?php

namespace App\Facades\Dependency;

use Illuminate\Support\Facades\Facade;

class ImportFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Import';
    }
}
