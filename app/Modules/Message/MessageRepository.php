<?php

namespace App\Modules\Message;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use RuntimeException;
use App\Modules\Message\RecordNotFoundException;

class MessageRepository implements Repository
{
    /**
     * Model.
     *
     * @var \App\Modules\Message\Models\Message
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
            'search' => ''
        ], $params);

        $model = $this->createModel();

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT `id` FROM `'.$model->getTable().'`';

        $useWhere = false;
        $isUseWhere = false;

        if (! empty($params['search'])) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ( ! empty($params['search'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= '(';
            $fromSql .= ' `title` LIKE "%'.$params['search'].'%"';
            $fromSql .= ' OR `sender` LIKE "%'.$params['sender'].'%"';
            $fromSql .= ' OR `phone` LIKE "%'.$params['phone'].'%"';
            $fromSql .= ' OR `email` LIKE "%'.$params['email'].'%"';
            $fromSql .= ')';

            $isUseWhere = true;
        }

        $fromSql .= ' ORDER BY `created_at` DESC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }

        $fromSql .= ') o';

        $query = $model->select($model->getTable().'.id');

        if ( ! empty($params['search'])) {
            $query->where(function($query) use ($model, $params) {
                $query->where($model->getTable().'.title', 'LIKE', '%'.$params['identifier'].'%')
                    ->orWhere($model->getTable().'.sender', 'LIKE', '%'.$params['sender'].'%')
                    ->orWhere($model->getTable().'.phone', 'LIKE', '%'.$params['phone'].'%')
                    ->orWhere($model->getTable().'.email', 'LIKE', '%'.$params['email'].'%');
            });
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
     * @return \App\Modules\Message\Models\Message
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
