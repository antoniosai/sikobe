<?php

namespace App\Modules\Message;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface Repository
{
    /**
     * Return list items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     *
     * @return \Message
     */
    public function search(Array $params = [], $page = 1, $limit = 10);

    /**
     * Find the item by it's ID.
     *
     * @param  integer $id
     *
     * @return \App\Modules\Message\Models\Message
     *
     * @throws \App\Modules\Message\RecordNotFoundException
     */
    public function find($id);

    /**
     * Create a new item.
     *
     * @param  Array $data
     *
     * @return \App\Modules\Message\Models\Message|null
     * @throws \RuntimeException
     */
    public function create(Array $data);

    /**
     * Return latest query total items.
     *
     * @return integer
     */
    public function getTotal();
}
