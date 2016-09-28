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

use App\Modules\CommandPost\Models\CommandPost as CommandPostContract;

use App\Presenter\Api\Territories\District;
use App\Presenter\Api\Territories\Village;
use App\Presenter\Api\File;

use App\Modules\Territory\RecordNotFoundException as TerritoryRecordNotFoundException;

class CommandPost extends TransformerAbstract
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
        'area', 
        'district', 
        'village', 
        'photos'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @param  CommandPostContract $item
     *
     * @return array
     */
    public function transform(CommandPostContract $item)
    {
        return [
            'id'         => (int) $item->id, 
            'title'      => $item->title, 
            'address'    => $item->address, 
            'leader'     => $item->leader, 
            'phone'      => $item->phone, 
            'latitude'   => (float) $item->latitude, 
            'longitude'  => (float) $item->longitude, 
            'status'     => $item->status, 
            'created_at' => $item->created_at, 
            'links'      => [
                [
                    'rel' => 'self',
                    'uri' => '/command-posts/'.$item->id,
                ]
            ]
        ];
    }

    /**
     * Include photos
     *
     * @param  CommandPostContract $post
     *
     * @return League\Fractal\Resource\Collection|null
     */
    public function includePhotos(CommandPostContract $post)
    {
        list($files) = $this->getFileService()->search([
            'object_type' => 'posko', 
            'object_id'   => $post->id
        ], 1, 0);

        return $this->collection($files, new File);
    }

    /**
     * Include District
     *
     * @param  CommandPostContract $post
     *
     * @return League\Fractal\Resource\Item|null
     */
    public function includeDistrict(CommandPostContract $post)
    {
        try {
            $village = $this->getTerritoryService()->getVillage($post->village_id);

            return $this->item(
                $this->getTerritoryService()->getDistrict($village->district_id), 
                new District
            );
        } catch (TerritoryRecordNotFoundException $e) {}

        return null;
    }

    /**
     * Include Village
     *
     * @param  CommandPostContract $post
     *
     * @return League\Fractal\Resource\Item|null
     */
    public function includeVillage(CommandPostContract $post)
    {
        try {
            return $this->item(
                $this->getTerritoryService()->getVillage($post->village_id), 
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
