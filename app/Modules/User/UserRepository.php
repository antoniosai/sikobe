<?php

namespace App\Modules\User;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use RuntimeException;
use App\Modules\User\RecordNotFoundException;

class UserRepository implements Repository
{
    /**
     * The model.
     *
     * @var \App\Modules\User\Models\User
     */
    protected $model;

    /**
     * The Meta model.
     *
     * @var \App\Modules\User\Models\UserMeta
     */
    protected $modelMeta;

    /**
     * The Group model.
     *
     * @var \App\Modules\User\Models\Group
     */
    protected $modelGroup;

    /**
     * The User Group model.
     *
     * @var \App\Modules\User\Models\UserGroup
     */
    protected $modelUserGroup;

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
     * @param string $modelMeta
     * @param string $modelGroup
     * @param string $modelUserGroup
     *
     * @return void
     */
    public function __construct($model, $modelMeta, $modelGroup, $modelUserGroup)
    {
        $this->model = $model;
        $this->modelMeta = $modelMeta;
        $this->modelGroup = $modelGroup;
        $this->modelUserGroup = $modelUserGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'activated'  => -1
        ], $params);

        $model = $this->createModel();

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT `'.$model->getTable().'`.`id` ';
        $fromSql .= 'FROM `'.$model->getTable().'` ';

        $useWhere = false;
        $isUseWhere = false;

        if ($params['activated'] > -1) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ($params['activated'] > -1) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `'.$model->getTable().'`.`activated` = '.$params['activated'];

            $isUseWhere = true;
        }

        $fromSql .= ' ORDER BY `'.$model->getTable().'`.`created_at` DESC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }

        $fromSql .= ') o';

        $query = $model->select($model->getTable().'.id');

        if ($params['activated'] > -1) {
            $query->where($model->getTable().'.activated', '=', $params['activated']);
        }

        $this->total = $query->count();

        $query = $model->newQuery()->select($model->getTable().'.*')
                    ->from($this->getDb()->raw($fromSql))
                    ->join($model->getTable(), $model->getTable().'.id', '=', 'o.id')
                    ->orderBy($model->getTable().'.created_at', 'DESC');

        unset($fromSql);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(Array $params)
    {
        $params = array_merge([
            'id'         => 0,
            'email'      => ''
        ], $params);

        $model = $this->createModel();

        $query = $model->newQuery()->select($model->getTable().'.*');

        if ( ! empty($params['id'])) {
            $query->where($model->getTable().'.id', '=', $params['id']);
        }

        if ( ! empty($params['email'])) {
            $query->where($model->getTable().'.email', '=', $params['email']);
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
    public function create(Array $data)
    {
        $model = $this->createModel();
        $model->fill($data);

        if ( ! $model->save()) {
            throw new RuntimeException('Failed to create the item');
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function updateMeta($userId, $key, $value)
    {
        try {
            $meta = $this->findMetaBy([
                'user_id' => $userId,
                'handle'  => $key
            ]);
        } catch (RecordNotFoundException $e) {
            $meta = null;
        }

        $data = [
            'user_id' => $userId,
            'handle'  => $key,
            'value'   => $value
        ];

        if (is_null($meta)) {
            return $this->createMeta($data);
        }

        $meta->fill($data);
        $meta->save();

        return $meta;
    }

    /**
     * Create a new meta item.
     *
     * @param  Array $data
     *
     * @return \App\Modules\User\Models\UserMeta
     * @throws \RuntimeException
     */
    private function createMeta(Array $data)
    {
        $model = $this->createModelMeta();
        $model->fill($data);

        if ( ! $model->save()) {
            throw new RuntimeException('Failed to create the meta');
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function findMetaBy(Array $params)
    {
        $params = array_merge([
            'id'      => 0,
            'user_id' => 0,
            'handle'  => ''
        ], $params);

        $model = $this->createModelMeta();

        $query = $model->newQuery()->select($model->getTable().'.*');

        if ( ! empty($params['id'])) {
            $query->where($model->getTable().'.id', '=', $params['id']);
        }

        if ( ! empty($params['user_id'])) {
            $query->where($model->getTable().'.user_id', '=', $params['user_id']);
        }

        if ( ! empty($params['handle'])) {
            $query->where($model->getTable().'.handle', '=', $params['handle']);
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
    public function findGroupBy(Array $params)
    {
        $params = array_merge([
            'id'   => 0,
            'name' => ''
        ], $params);

        $model = $this->createModelGroup();

        $query = $model->newQuery()->select($model->getTable().'.*');

        if ( ! empty($params['id'])) {
            $query->where($model->getTable().'.id', '=', $params['id']);
        }

        if ( ! empty($params['name'])) {
            $query->where($model->getTable().'.name', '=', $params['name']);
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
    public function addToGroup($userId, $groupId)
    {
        $model = $this->createModelUserGroup();
        $model->fill([
            'user_id'  => $userId,
            'group_id' => $groupId
        ]);

        $model->save();

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function removeFromGroup($userId, $groupId)
    {
        return $this->createModelUserGroup()
                    ->where('user_id', '=', $userId)
                    ->where('group_id', '=', $groupId)
                    ->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Create a new instance of the user model.
     *
     * @return \App\Modules\User\Models\User
     */
    private function createModel()
    {
        return new $this->model;
    }

    /**
     * Create a new instance of the meta model.
     *
     * @return \App\Modules\User\Models\UserMeta
     */
    private function createModelMeta()
    {
        return new $this->modelMeta;
    }

    /**
     * Create a new instance of the group model.
     *
     * @return \App\Modules\User\Models\Group
     */
    private function createModelGroup()
    {
        return new $this->modelGroup;
    }

    /**
     * Create a new instance of the user group model.
     *
     * @return \App\Modules\User\Models\UserGroup
     */
    private function createModelUserGroup()
    {
        return new $this->modelUserGroup;
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
