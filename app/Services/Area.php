<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\Area\Repository;

use RuntimeException;

class Area extends Service
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
        $repository = $this->getAreaRepository();
        $collection = $repository->search($params, $page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Return Area instance.
     *
     * @return \App\Modules\Area\Repository
     */
    private function getAreaRepository()
    {
        return app(Repository::class);
    }
}
