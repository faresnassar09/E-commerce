<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AuthSeller  extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\AuthSeller::class; 
    }
}
  