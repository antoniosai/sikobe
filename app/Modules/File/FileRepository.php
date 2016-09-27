<?php

namespace App\Modules\File;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use RuntimeException;
use App\Modules\File\RecordNotFoundException;

class FileRepository implements Repository
{
    /**
     * Model.
     *
     * @var \App\Modules\File\Models\File
     */
    protected $model;

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
     * 
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'object_type' => '', 
            'object_id'   => 0, 
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

        if ( ! empty($params['object_type'])
         || ! empty($params['object_id'])
         || $params['is_active'] > -1) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ( ! empty($params['object_type'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `object_type` = "'.$params['object_type'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['object_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `object_id` = '.$params['object_id'];

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

        if ( ! empty($params['object_type'])) {
            $query->where($model->getTable().'.object_type', '=', $params['object_type']);
        }

        if ( ! empty($params['object_id'])) {
            $query->where($model->getTable().'.object_id', '=', $params['object_id']);
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
            'object_type' => 'account', 
            'object_id'   => 0, 
            'id'          => 0
        ], $params);

        $model = $this->createModel();

        $query = $model->newQuery()->select($model->getTable().'.*');

        if ( ! empty($params['object_type'])) {
            $query->where($model->getTable().'.object_type', '=', $params['object_type']);
        }
        if ( ! empty($params['object_id'])) {
            $query->where($model->getTable().'.object_id', '=', $params['object_id']);
        }

        if ( ! empty($params['id'])) {
            $query->where($model->getTable().'.id', '=', $params['id']);
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
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Create a new instance of the model.
     *
     * @return \App\Modules\File\Models\File
     */
    private function createModel()
    {
        return new $this->model;
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
