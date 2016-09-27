<?php

namespace App\Modules\Area;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use RuntimeException;
use App\Modules\Area\RecordNotFoundException;

class AreaRepository implements Repository
{
    /**
     * Model.
     *
     * @var \App\Modules\Area\Models\Area
     */
    protected $model;

    /**
     * Model Status.
     *
     * @var \App\Modules\Area\Models\Status
     */
    protected $modelStatus;

    /**
     * Current total query rows.
     *
     * @var integer
     */
    protected $total = 0;

    /**
     * Create a new instance.
     *
     * @param string $model
     * @param string $modelStatus
     * 
     * @return void
     */
    public function __construct($model, $modelStatus)
    {
        $this->model = $model;
        $this->modelStatus = $modelStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'author_id'   => '', 
            'identifier'  => '', 
            'district_id' => '', 
            'village_id'  => '', 
            'title'       => '', 
            'is_active'   => 1
        ], $params);

        $model = $this->createModel();

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT `id` FROM `'.$model->getTable().'`';

        $useWhere = false;
        $isUseWhere = false;

        if ( ! empty($params['author_id'])
         || ! empty($params['identifier'])
         || ! empty($params['district_id'])
         || ! empty($params['village_id'])
         || ! empty($params['title'])
         || $params['is_active'] > -1) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ( ! empty($params['author_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `author_id` = '.$params['author_id'];

            $isUseWhere = true;
        }

        if ( ! empty($params['identifier'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `identifier` = "'.$params['identifier'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['district_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `district_id` = "'.$params['district_id'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['village_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `village_id` = "'.$params['village_id'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['title'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `title` LIKE "%'.$params['title'].'%"';

            $isUseWhere = true;
        }

        if ($params['is_active'] > -1) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `is_active` = '.$params['is_active'];

            $isUseWhere = true;
        }

        $fromSql .= ' ORDER BY `created_at` DESC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }

        $fromSql .= ') o';

        $query = $model->select($model->getTable().'.id');

        if ( ! empty($params['author_id'])) {
            $query->where($model->getTable().'.author_id', '=', $params['author_id']);
        }

        if ( ! empty($params['identifier'])) {
            $query->where($model->getTable().'.identifier', '=', $params['identifier']);
        }

        if ( ! empty($params['district_id'])) {
            $query->where($model->getTable().'.district_id', '=', $params['district_id']);
        }

        if ( ! empty($params['village_id'])) {
            $query->where($model->getTable().'.village_id', '=', $params['village_id']);
        }

        if ( ! empty($params['title'])) {
            $query->where($model->getTable().'.title', 'LIKE', '%'.$params['title'].'%');
        }

        if ($params['is_active'] > -1) {
            $query->where($model->getTable().'.is_active', '=', $params['is_active']);
        }

        $this->total = $query->count();

        $query = $model->newQuery()->select($model->getTable().'.*')
                    ->from($this->getDb()->raw($fromSql))
                    ->join($model->getTable(), $model->getTable().'.id', '=', 'o.id')
                    ->orderBy($model->getTable().'.created_at', 'DESC');

        unset($fromSql);
        unset($model);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(Array $params)
    {
        $params = array_merge([
            'id'          => 0, 
            'author_id'   => 0, 
            'identifier'  => ''
        ], $params);

        $model = $this->createModel();

        $query = $model->newQuery()->select($model->getTable().'.*');

        if ( ! empty($params['id'])) {
            $query->where($model->getTable().'.id', '=', $params['id']);
        }

        if ( ! empty($params['author_id'])) {
            $query->where($model->getTable().'.author_id', '=', $params['author_id']);
        }

        if ( ! empty($params['identifier'])) {
            $query->where($model->getTable().'.identifier', '=', $params['identifier']);
        }

        unset($model);

        $item = $query->first();
        
        if (is_null($item)) {
            throw new RecordNotFoundException('Item not found!');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $item = $this->createModel()->find($id);

        if ( ! is_object($item)) {
            throw new RecordNotFoundException('No item found');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function create(Array $data)
    {
        $item = $this->createModel();
        $item->fill($data);

        if ( ! $item->save()) {
            throw new RuntimeException('Failed to create the item');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function searchStatus(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'area_id'   => '',
            'author_id' => '', 
            'is_active' => 1
        ], $params);

        $model = $this->createModelStatus();

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT `id` FROM `'.$model->getTable().'`';

        $useWhere = false;
        $isUseWhere = false;

        if ( ! empty($params['area_id'])
         || ! empty($params['author_id'])
         || $params['is_active'] > -1) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ( ! empty($params['area_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `area_id` = '.$params['area_id'];

            $isUseWhere = true;
        }

        if ( ! empty($params['author_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `author_id` = '.$params['author_id'];

            $isUseWhere = true;
        }

        if ($params['is_active'] > -1) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `is_active` = '.$params['is_active'];

            $isUseWhere = true;
        }

        $fromSql .= ' ORDER BY `created_at` DESC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }
        
        $fromSql .= ') o';

        $query = $model->select($model->getTable().'.id');

        if ( ! empty($params['area_id'])) {
            $query->where($model->getTable().'.area_id', '=', $params['area_id']);
        }

        if ( ! empty($params['author_id'])) {
            $query->where($model->getTable().'.author_id', '=', $params['author_id']);
        }

        if ($params['is_active'] > -1) {
            $query->where($model->getTable().'.is_active', '=', $params['is_active']);
        }

        $this->total = $query->count();

        $query = $model->newQuery()->select($model->getTable().'.*')
                    ->from($this->getDb()->raw($fromSql))
                    ->join($model->getTable(), $model->getTable().'.id', '=', 'o.id')
                    ->orderBy($model->getTable().'.created_at', 'DESC');

        unset($fromSql);
        unset($model);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findStatus($id)
    {
        $item = $this->createModelStatus()->find($id);

        if ( ! is_object($item)) {
            throw new RecordNotFoundException('No item found');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function createStatus(Array $data)
    {
        $item = $this->createModelStatus();
        $item->fill($data);

        if ( ! $item->save()) {
            throw new RuntimeException('Failed to create the item');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * {@inheritdoc}
     */
    public function createModel()
    {
        return new $this->model;
    }

    /**
     * {@inheritdoc}
     */
    public function createModelStatus()
    {
        return new $this->modelStatus;
    }

    /**
     * Create a DB instance.
     *
     * @return mixed
     */
    private function getDb()
    {
        return app('db');
    }
}
