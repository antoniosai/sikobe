<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\Territory\Repository;

class Territory extends Service
{
    /**
     * Search province items.
     *
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return array
     * @throws \RuntimeException
     */
    public function searchProvinces($page = 1, $limit = 10)
    {
        $repository = $this->getTerritoryRepository();
        $collection = $repository->searchProvinces($page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Search regency items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return array
     * @throws \RuntimeException
     */
    public function searchRegencies(Array $params = [], $page = 1, $limit = 10)
    {
        $repository = $this->getTerritoryRepository();
        $collection = $repository->searchRegencies($params, $page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Search district items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return array
     * @throws \RuntimeException
     */
    public function searchDistricts(Array $params = [], $page = 1, $limit = 10)
    {
        $repository = $this->getTerritoryRepository();
        $collection = $repository->searchDistricts($params, $page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Search village items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return array
     * @throws \RuntimeException
     */
    public function searchVillages(Array $params = [], $page = 1, $limit = 10)
    {
        $repository = $this->getTerritoryRepository();
        $collection = $repository->searchVillages($params, $page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Return a province.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Territory\Models\Province
     * @throws \App\Modules\Territory\RecordNotFoundException
     */
    public function getProvince($id)
    {
        return $this->getTerritoryRepository()->findProvince($id);
    }

    /**
     * Return a regency.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Territory\Models\Regency
     * @throws \App\Modules\Territory\RecordNotFoundException
     */
    public function getRegency($id)
    {
        return $this->getTerritoryRepository()->findRegency($id);
    }

    /**
     * Return a district.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Territory\Models\District
     * @throws \App\Modules\Territory\RecordNotFoundException
     */
    public function getDistrict($id)
    {
        return $this->getTerritoryRepository()->findDistrict($id);
    }

    /**
     * Return a village.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Territory\Models\Village
     * @throws \App\Modules\Territory\RecordNotFoundException
     */
    public function getVillage($id)
    {
        return $this->getTerritoryRepository()->findVillage($id);
    }

    /**
     * Return Territory instance.
     *
     * @return \App\Modules\Territory\Repository
     */
    private function getTerritoryRepository()
    {
        return app(Repository::class);
    }
}
