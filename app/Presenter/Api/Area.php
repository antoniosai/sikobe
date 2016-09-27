<?php

namespace App\Presenter\Api;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Support\Str;

use League\Fractal\TransformerAbstract;

use App\Services\Territory as TerritoryService;
use App\Services\File as FileService;

use App\Modules\Area\Models\Area as AreaContract;

use App\Presenter\Api\Territories\Province;
use App\Presenter\Api\Territories\Regency;
use App\Presenter\Api\Territories\District;
use App\Presenter\Api\Territories\Village;

use App\Modules\Territory\RecordNotFoundException as TerritoryRecordNotFoundException;

class Area extends TransformerAbstract
{
    /**
     * The Territory Service instance.
     *
     * @var \App\Services\Territory
     */
    protected $territoryService;

    /**
     * The File Service instance.
     *
     * @var \App\Services\File
     */
    protected $fileService;

    /**
     * {@inheritdoc}
     */
    protected $availableIncludes = [
        'province', 
        'regency', 
        'district', 
        'village', 
        'photos'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @param  AreaContract $item
     *
     * @return array
     */
    public function transform(AreaContract $item)
    {
        return [
            'id'                => (int) $item->id, 
            'identifier'        => $item->identifier, 
            'title'             => $item->title, 
            'short_description' => Str::words($item->description, 15, '...'), 
            'description'       => $item->description, 
            'address'           => $item->address, 
            'latitude'          => (float) $item->latitude, 
            'longitude'         => (float) $item->longitude, 
            'status'            => $item->status, 
            'created_at'        => $item->created_at, 
            'links'             => [
                [
                    'rel' => 'self',
                    'uri' => '/areas/'.$item->identifier,
                ]
            ]
        ];
    }

    /**
     * Include photos
     *
     * @param  AreaContract $area
     *
     * @return League\Fractal\Resource\Collection|null
     */
    public function includePhotos(AreaContract $area)
    {
        list($files) = $this->getFileService()->search([
            'object_type' => 'area', 
            'object_id'   => $area->id
        ], 1, 0);

        return $this->collection($files, new File);
    }

    /**
     * Include Province
     *
     * @param  AreaContract $area
     *
     * @return League\Fractal\Resource\Item|null
     */
    public function includeProvince(AreaContract $area)
    {
        try {
            return $this->item(
                $this->getTerritoryService()->getProvince($area->province_id), 
                new Province
            );
        } catch (TerritoryRecordNotFoundException $e) {}

        return null;
    }

    /**
     * Include Regency
     *
     * @param  AreaContract $area
     *
     * @return League\Fractal\Resource\Item|null
     */
    public function includeRegency(AreaContract $area)
    {
        try {
            return $this->item(
                $this->getTerritoryService()->getRegency($area->regency_id), 
                new Regency
            );
        } catch (TerritoryRecordNotFoundException $e) {}

        return null;
    }

    /**
     * Include District
     *
     * @param  AreaContract $area
     *
     * @return League\Fractal\Resource\Item|null
     */
    public function includeDistrict(AreaContract $area)
    {
        try {
            return $this->item(
                $this->getTerritoryService()->getDistrict($area->district_id), 
                new District
            );
        } catch (TerritoryRecordNotFoundException $e) {}

        return null;
    }

    /**
     * Include Village
     *
     * @param  AreaContract $area
     *
     * @return League\Fractal\Resource\Item|null
     */
    public function includeVillage(AreaContract $area)
    {
        try {
            return $this->item(
                $this->getTerritoryService()->getVillage($area->village_id), 
                new Village
            );
        } catch (TerritoryRecordNotFoundException $e) {}

        return null;
    }

    /**
     * Return the territory service instance.
     *
     * @return \App\Services\Territory
     */
    private function getTerritoryService()
    {
        if (is_null($this->territoryService)) {
            $this->territoryService = new TerritoryService();
        }

        return $this->territoryService;
    }

    /**
     * Return the file service instance.
     *
     * @return \App\Services\File
     */
    private function getFileService()
    {
        if (is_null($this->fileService)) {
            $this->fileService = new FileService();
        }

        return $this->fileService;
    }

}
