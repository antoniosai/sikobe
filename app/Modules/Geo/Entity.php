<?php

namespace App\Modules\Geo;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Entity implements EntityInterface
{
    /**
     * Country code.
     *
     * @var string
     */
    public $countryCode;

    /**
     * Country name.
     *
     * @var string
     */
    public $countryName;

    /**
     * Record raw.
     *
     * @var string
     */
    public $recordRaw;

    /**
     * Create a new instance.
     *
     * @param string $countryCode
     * @param string $countryName
     * @param string $recordRaw
     * 
     * @return void
     */
    public function __construct($countryCode, $countryName, $recordRaw)
    {
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
        $this->recordRaw   = $recordRaw;
    }
}
