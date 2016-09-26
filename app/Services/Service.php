<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\User;

class Service
{
    /**
     * The User instance.
     *
     * @var \App\Modules\User\Models\User
     */
    protected $user;

    /**
     * Set current user instance.
     *
     * @param  \App\Modules\User\Models\User $user
     * 
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Return Request instance.
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return app('request');
    }
}
