<?php

namespace App\Http\Controllers\Front;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tymon\JWTAuth\JWTAuth;

use App\Http\Controllers\Controller as BaseController;
use App\Support\Asset;

use App\Token;

class Controller extends BaseController
{
    /**
     * The JWT Auth instance.
     *
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $JWTAuth;

    /**
     * The JWT Token.
     *
     * @var string
     */
    protected $JWT;

    /**
     * Create a new controller instance.
     * 
     * @param  Tymon\JWTAuth\JWTAuth  $JWTAuth
     *
     * @return void
     */
    public function __construct(JWTAuth $JWTAuth)
    {
        $this->JWTAuth = $JWTAuth;
        $this->JWT = $this->JWTAuth->fromUser(new Token());

        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == 'on') {
                Asset::$secure = true;
            }
        }

        $apiParams = [
            'url'     => env('API_SCHEME').'://'.env('API_DOMAIN'), 
            'headers' => [
                'Accept' => 'application/'.env('API_STANDARDS_TREE').'..v1+json'
            ], 
            'token'   => $this->JWT
        ];
        $scripts = 'var apiClient = ddClient('.json_encode($apiParams).');';
        
        Asset::addScript($scripts, 'footer.scripts');
    }
}
