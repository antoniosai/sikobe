<?php

namespace App\Modules\Geo\Vendors;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GeoIp2\Database\Reader;

use GeoIp2\Exception\GeoIp2Exception;
use App\Modules\Geo\RecordNotFoundException;

class MaxMind implements Vendor
{
    /**
     * Service DB path.
     *
     * @var string
     */
    protected $db;

    /**
     * Create a new instance.
     *
     * @param  string  $db
     * 
     * @return void
     */
    public function __construct($db)
    {
        $this->db  = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function locateByIP($ipAddress)
    {
        $countryCode = null;
        $countryName = null;
        $recordRaw   = null;

        // Check IP Address in local maxmind db
        try {
            $reader = new Reader($this->db);
            $record = $reader->country($ipAddress);

            $countryCode = $record->country->isoCode;
            $countryName = $record->country->names['en'];
            $recordRaw   = json_encode($record);

            unset($reader);
            unset($record);
        } catch (GeoIp2Exception $e) {
            throw new RecordNotFoundException($e->getMessage());
        }

        return [$countryCode, $countryName, $recordRaw];
    }
}
