<?php

namespace App\Interfaces\Api;

interface AuthInterface
{
    /**
     * register
     *
     * @return void
     */
    public function register($request);

    /**
     * register
     *
     * @param mixed
     * @return void
     */
    public function login($request);
}
