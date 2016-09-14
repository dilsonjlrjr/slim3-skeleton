<?php

namespace App\AuthAdapters;

use App\Mapper\User;
use SlimAuth\AuthAdapterInterface;
use SlimAuth\AuthResponse;

class AuthAdapterUser implements AuthAdapterInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * AuthAdapterUser constructor.
     *
     * @param $username string
     * @param $password string
     */
    public function __construct(string $username, string $password)
    {
        $this->username;
        $this->password;
    }

    function authenticate() : AuthResponse
    {



    }

}