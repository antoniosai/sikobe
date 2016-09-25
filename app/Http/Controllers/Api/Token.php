<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Tymon\JWTAuth\JWTAuth;

use Dingo\Api\Routing\Helpers;

class Token extends Controller
{
    use Helpers;

    /**
     * Response to the refresh token request.
     * 
     * @return \Illuminate\Http\Response
     */
    public function refreshToken()
    {
        return $this->response->array([]);
    }
}
