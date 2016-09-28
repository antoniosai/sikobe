<?php

namespace App\Http\Controllers\Api;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
