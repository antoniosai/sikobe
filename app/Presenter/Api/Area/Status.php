<?php

namespace App\Presenter\Api\Area;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Support\Str;

use League\Fractal\TransformerAbstract;

use App\Modules\Area\Models\Status as StatusContract;

use App\Services\File as FileService;

use App\Presenter\Api\File;

use DateTime;

class Status extends TransformerAbstract
{
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
        'photos', 
        'latest_status'
    ];

    /**
     * Turn this item object into a generic array
     *
     * @param  StatusContract $item
     *
     * @return array
     */
    public function transform(StatusContract $item)
    {
        return [
            'id'                => (int) $item->id, 
            'identifier'        => $item->identifier, 
            'short_description' => Str::words($item->description, 10, '...'), 
            'description'       => $item->description, 
            'scale'             => (int) $item->scale, 
            'datetime'          => new DateTime($item->datetime), 
            'created_at'        => $item->created_at
        ];
    }

    /**
     * Include photos
     *
     * @param  StatusContract $status
     *
     * @return League\Fractal\Resource\Collection|null
     */
    public function includePhotos(StatusContract $status)
    {
        list($files) = $this->getFileService()->search([
            'object_type' => 'area_status', 
            'object_id'   => $status->id
        ], 1, 0);

        return $this->collection($files, new File);
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
