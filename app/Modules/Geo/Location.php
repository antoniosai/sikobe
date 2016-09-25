<?php

namespace App\Modules\Geo;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\Geo\Vendors\MaxMind;

use App\Modules\Geo\RecordNotFoundException;

class Location
{
    /**
     * Geo driver.
     *
     * @var string
     */
    protected $driver;

    /**
     * Geo driver properties.
     *
     * @var array
     */
    protected $props;

    /**
     * Geo vendor.
     *
     * @var App\Modules\Geo\Vendors\Vendor
     */
    protected $vendor;

    /**
     * Create a new instance.
     *
     * @param string $driver
     * @param array  $props
     * 
     * @return void
     */
    public function __construct($driver, $props)
    {
        $this->driver = $driver;
        $this->props  = $props;
    }

    /**
     * Get vendor.
     *
     * @return App\Modules\Geo\Vendors\Vendor
     */
    public function getVendor()
    {
        if (is_null($this->vendor)) {
            $this->loadVendor();
        }

        return $this->vendor;
    }

    /**
     * Locate geo based on IP address.
     *
     * @return App\Modules\Geo\Vendors\Vendor||null
     */
    public function locateByIP()
    {
        try {
            list(
                $countryCode, 
                $countryName, 
                $recordRaw
            ) = $this->getVendor()->locateByIP($_SERVER['REMOTE_ADDR']);
        } catch (RecordNotFoundException $e) {
            return null;
        }

        return new Entity($countryCode, $countryName, $recordRaw);
    }

    /**
     * Load vendor.
     *
     * @return void
     */
    private function loadVendor()
    {
        switch ($this->driver) {
            case 'maxmind':
                $this->vendor = new MaxMind($this->props['db']);
                break;
        }
    }
}
