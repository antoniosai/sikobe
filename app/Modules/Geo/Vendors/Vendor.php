<?php

namespace App\Modules\Geo\Vendors;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface Vendor
{
    /**
     * Locate geo based on IP address.
     *
     * @param  string $ipAddress
     * 
     * @return array
     * @throws App\Modules\Geo\RecordNotFoundException
     */
    public function locateByIP($ipAddress);
}
