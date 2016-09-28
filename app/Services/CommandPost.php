<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\CommandPost\Repository;

use Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\Territory as TerritoryService;
use App\Services\File as FileService;

use RuntimeException;
use App\Modules\CommandPost\RecordNotFoundException;

class CommandPost extends Service
{
    /**
     * Search items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return array
     * @throws \RuntimeException
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'district_id' => '', 
            'village_id'  => ''
        ], $params);

        if ( ! empty($params['district_id']) && empty($params['village_id'])) {
            list($vilages) = $this->getTerritoryService()->searchVillages([
                'district_id' => $params['district_id']
            ], 1, 0);

            $vilageIds = [];
            if ( ! $vilages->isEmpty()) {
                foreach ($vilages as $village) {
                    $vilageIds[] = $village->id;
                }
            }

            unset($vilages);

            $params['village_id'] = $vilageIds;
        }

        $repository = $this->getCommandPostRepository();
        $collection = $repository->search($params, $page, $limit);

        return new LengthAwarePaginator(
            $collection->all(), 
            $repository->getTotal(), 
            ($limit > 0) ? $limit : 1, 
            $page, 
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * Return a item.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Area\Models\Area
     * @throws \App\Modules\Area\RecordNotFoundException
     */
    public function get($id)
    {
        return $this->getAreaRepository()->find($id);
    }

    /**
     * Return item photos.
     *
     * @param  integer $id
     * 
     * @return \Collection
     * @throws \App\Modules\Area\RecordNotFoundException
     */
    public function getPhotos($id)
    {
        $post = $this->get($id);

        list($files) = $this->getFileService()->search([
            'object_type' => 'posko', 
            'object_id'   => $post->id
        ], 1, 0);

        return $files;
    }

    /**
     * Return the territory service instance.
     *
     * @return \App\Services\Territory
     */
    private function getTerritoryService()
    {
        $service = new TerritoryService();

        return $service;
    }

    /**
     * Return the file service instance.
     *
     * @return \App\Services\File
     */
    private function getFileService()
    {
        $service = new FileService();

        return $service;
    }

    /**
     * Return CommandPost instance.
     *
     * @return \App\Modules\CommandPost\Repository
     */
    private function getCommandPostRepository()
    {
        return app(Repository::class);
    }
}
