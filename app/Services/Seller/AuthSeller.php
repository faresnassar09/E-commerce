<?php

namespace App\Services\Seller;

use App\Models\Seller\Seller;
use Illuminate\Auth\AuthManager;
use Illuminate\Log\LogManager;


class AuthSeller
{

    public $seller = null;


    public function __construct()
    {

        $this->seller = app(AuthManager::class)->guard('seller')->user();
    }

    public function makeUserAuthentcated($seller)
    {

        app(AuthManager::class)->guard('seller')->login($seller);

        $this->seller = app(AuthManager::class)->guard('seller')->user();
    }


    public function fullInfo()
    {

        return $this->seller;
    }


    public function check(): bool
    {
        return $this->seller !== null;
    }

    public function id()
    {

        return $this->seller?->id;
    }

    public function name()
    {

        return $this->seller?->name;
    }

    public function email()
    {

        return $this->seller?->email;
    }


    public function notActive()
    {

        return $this->seller->status === 0;
    }
    public function active()
    {

        return $this->seller->status === 1;
    }

 
    public function deleteCache($key)
    {

        app('cache')->forget($key);
    }
}

