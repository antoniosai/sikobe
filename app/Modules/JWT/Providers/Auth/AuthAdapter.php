<?php

namespace App\Modules\JWT\Providers\Auth;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Tymon\JWTAuth\Providers\Auth\AuthInterface;

use App\Token;

class AuthAdapter implements AuthInterface
{
    /**
     * Check a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function byCredentials(array $credentials = [])
    {
        return true;
    }

    /**
     * Authenticate a user via the id.
     *
     * @param  mixed  $id
     * @return bool
     */
    public function byId($id)
    {
        $token = new Token();

        return $token->id == $id;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return mixed
     */
    public function user()
    {
        return new Token();
    }
}
