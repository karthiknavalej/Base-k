<?php

namespace App\Facades\Dependency;

use Illuminate\Support\Facades\Facade;

class ExcelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Excel';
    }
}
