<?php

namespace App;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Token
{
    /**
     * The ID.
     *
     * @var string
     */
    public $id;

    /**
     * Create the Token instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->id = env('JWT_KEY');
    }
}
