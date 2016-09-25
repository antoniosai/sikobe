<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Service
{
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
