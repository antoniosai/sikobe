<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\File\Repository;

class File extends Service
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
        $repository = $this->getFileRepository();
        $collection = $repository->search($params, $page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Create a item.
     *
     * @param  array  $data
     * 
     * @return \App\Modules\File\Models\File
     * @throws \RuntimeException
     */
    public function create(Array $data)
    {
        return $this->getFileRepository()->create($data);
    }

    /**
     * Return File instance.
     *
     * @return \App\Modules\File\Repository
     */
    private function getFileRepository()
    {
        return app(Repository::class);
    }
}
