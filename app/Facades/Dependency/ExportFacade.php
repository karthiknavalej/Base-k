<?php

namespace App\Facades\Dependency;

use Illuminate\Support\Facades\Facade;

class ExportFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Export';
    }
}
