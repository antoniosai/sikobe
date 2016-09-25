<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller as BaseController;

use Dingo\Api\Auth\Auth;

use RuntimeException;

class Controller extends BaseController
{
    /**
     * The Auth instance.
     *
     * @var \Dingo\Api\Auth\Auth
     */
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @param  \Dingo\Api\Auth\Auth  $auth
     * 
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
}
