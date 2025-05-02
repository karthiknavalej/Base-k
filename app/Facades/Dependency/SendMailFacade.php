<?php

namespace App\Facades\Dependency;

use Illuminate\Support\Facades\Facade;

class SendMailFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SendMail';
    }
}
