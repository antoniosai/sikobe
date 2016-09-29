<?php

namespace App\Modules\Territory;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use RuntimeException;
use App\Modules\Territory\RecordNotFoundException;

class TerritoryRepository implements Repository
{
    /**
     * Model Province
     *
     * @var \App\Modules\Territory\Models\Province
     */
    protected $modelProvince;

    /**
     * Model Regency
     *
     * @var \App\Modules\Territory\Models\Regency
     */
    protected $modelRegency;

    /**
     * Model District
     *
     * @var \App\Modules\Territory\Models\District
     */
    protected $modelDistrict;

    /**
     * Model Village
     *
     * @var \App\Modules\Territory\Models\Village
     */
    protected $modelVillage;

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
    public function __construct(#
        $modelProvince, 
        $modelRegency, 
        $modelDistrict, 
        $modelVillage
    )
    {
        $this->modelProvince = $modelProvince;
        $this->modelRegency  = $modelRegency;
        $this->modelDistrict = $modelDistrict;
        $this->modelVillage  = $modelVillage;
    }

    /**
     * {@inheritdoc}
     */
    public function searchProvinces($page = 1, $limit = 10)
    {
        $model = $this->createModelProvince();

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT `id` FROM `'.$model->getTable().'`';
        $fromSql .= ' ORDER BY `id` ASC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }

        $fromSql .= ') o';

        $this->total = $model->select($model->getTable().'.id')->count();

        $query = $model->newQuery()->select($model->getTable().'.*')
                    ->from($this->getDb()->raw($fromSql))
                    ->join($model->getTable(), $model->getTable().'.id', '=', 'o.id')
                    ->orderBy($model->getTable().'.id', 'ASC');

        unset($fromSql);
        unset($model);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findProvince($id)
    {
        $item = $this->createModelProvince()->find($id);

        if ( ! is_object($item)) {
            throw new RecordNotFoundException('No item found');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function searchRegencies(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'province_id' => '', 
            'order_by'    => 'id'
        ], $params);

        $model = $this->createModelRegency();

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT `id` FROM `'.$model->getTable().'`';

        $useWhere = false;
        $isUseWhere = false;

        if ( ! empty($params['province_id'])) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ( ! empty($params['province_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `province_id` = "'.$params['province_id'].'"';

            $isUseWhere = true;
        }

        $fromSql .= ' ORDER BY `'.$params['order_by'].'` ASC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }

        $fromSql .= ') o';

        $query = $model->select($model->getTable().'.id');

        if ( ! empty($params['province_id'])) {
            $query->where($model->getTable().'.province_id', '=', $params['province_id']);
        }

        $this->total = $query->count();

        $query = $model->newQuery()->select($model->getTable().'.*')
                    ->from($this->getDb()->raw($fromSql))
                    ->join($model->getTable(), $model->getTable().'.id', '=', 'o.id')
                    ->orderBy($model->getTable().'.'.$params['order_by'], 'ASC');

        unset($fromSql);
        unset($model);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findRegency($id)
    {
        $item = $this->createModelRegency()->find($id);

        if ( ! is_object($item)) {
            throw new RecordNotFoundException('No item found');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function searchDistricts(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'province_id' => '', 
            'regency_id'  => '', 
            'order_by'    => 'id'
        ], $params);

        $model = $this->createModelDistrict();
        if ( ! empty($params['province_id'])) {
            $modelProvince = $this->createModelProvince();
            $modelRegency = $this->createModelRegency();
        }

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT';
        $fromSql .= ' `'.$model->getTable().'`.`id`';
        
        if ( ! empty($params['province_id'])) {
            $fromSql .= ', `'.$modelProvince->getTable().'`.`name` AS province';
            $fromSql .= ', `'.$modelRegency->getTable().'`.`name` AS regency';
        }

        $fromSql .= ' FROM `'.$model->getTable().'`';

        if ( ! empty($params['province_id'])) {
            $fromSql .= ' LEFT JOIN `'.$modelRegency->getTable().'`';
            $fromSql .= ' ON `'.$model->getTable().'`.`regency_id`';
            $fromSql .= ' =';
            $fromSql .= ' `'.$modelRegency->getTable().'`.`id`';

            $fromSql .= ' LEFT JOIN `'.$modelProvince->getTable().'`';
            $fromSql .= ' ON `'.$modelRegency->getTable().'`.`province_id`';
            $fromSql .= ' =';
            $fromSql .= ' `'.$modelProvince->getTable().'`.`id`';
        }

        $useWhere = false;
        $isUseWhere = false;

        if ( ! empty($params['province_id'])
         || ! empty($params['regency_id'])) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ( ! empty($params['province_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `'.$modelRegency->getTable().'`.`province_id` = "'.$params['province_id'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['regency_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `'.$model->getTable().'`.`regency_id` = "'.$params['regency_id'].'"';

            $isUseWhere = true;
        }

        $fromSql .= ' ORDER BY `'.$model->getTable().'`.`'.$params['order_by'].'` ASC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }

        $fromSql .= ') o';

        $query = $model->select($model->getTable().'.id');

        if ( ! empty($params['province_id'])) {
            $query->leftJoin(
                $modelRegency->getTable(), 
                $model->getTable().'.regency_id', 
                '=', 
                $modelRegency->getTable().'.id'
            );
        }

        if ( ! empty($params['province_id'])) {
            $query->where($modelRegency->getTable().'.province_id', '=', $params['province_id']);
        }

        if ( ! empty($params['regency_id'])) {
            $query->where($model->getTable().'.regency_id', '=', $params['regency_id']);
        }

        $this->total = $query->count();

        $select = [
            $model->getTable().'.*'
        ];
        if ( ! empty($params['regency_id'])) {
            $select[] = 'o.province';
            $select[] = 'o.regency';
        }

        $query = $model->newQuery()->select($select)
                    ->from($this->getDb()->raw($fromSql))
                    ->join($model->getTable(), $model->getTable().'.id', '=', 'o.id')
                    ->orderBy($model->getTable().'.'.$params['order_by'], 'ASC');

        unset($fromSql);
        unset($model);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findDistrict($id)
    {
        $item = $this->createModelDistrict()->find($id);

        if ( ! is_object($item)) {
            throw new RecordNotFoundException('No item found');
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function searchVillages(Array $params = [], $page = 1, $limit = 10)
    {
        $params = array_merge([
            'area_table'  => '', 
            'province_id' => '', 
            'regency_id'  => '', 
            'district_id' => '', 
            'order_by'    => 'id'
        ], $params);

        $model = $this->createModelVillage();

        if ( ! empty($params['province_id']) || ! empty($params['province_id'])) {
            $modelRegency = $this->createModelRegency();
            $modelDistrict = $this->createModelDistrict();
        }

        if (empty($page)) {
            $page = 1;
        }

        $fromSql = '(';
        $fromSql .= 'SELECT';
        $fromSql .= ' `'.$model->getTable().'`.`id`';
        
        if ( ! empty($params['regency_id'])) {
            $fromSql .= ', `'.$modelRegency->getTable().'`.`name` AS regency';
            $fromSql .= ', `'.$modelDistrict->getTable().'`.`name` AS district';
        }

        $fromSql .= ' FROM `'.$model->getTable().'`';

        if ( ! empty($params['province_id']) || ! empty($params['province_id'])) {
            $fromSql .= ' LEFT JOIN `'.$modelDistrict->getTable().'`';
            $fromSql .= ' ON `'.$model->getTable().'`.`district_id`';
            $fromSql .= ' =';
            $fromSql .= ' `'.$modelDistrict->getTable().'`.`id`';

            $fromSql .= ' LEFT JOIN `'.$modelRegency->getTable().'`';
            $fromSql .= ' ON `'.$modelDistrict->getTable().'`.`regency_id`';
            $fromSql .= ' =';
            $fromSql .= ' `'.$modelRegency->getTable().'`.`id`';
        }

        $useWhere = false;
        $isUseWhere = false;

        if ( ! empty($params['province_id'])
         || ! empty($params['regency_id'])
         || ! empty($params['district_id'])) {
            $useWhere = true;
        }

        if ($useWhere) {
            $fromSql .= ' WHERE';
        }

        if ( ! empty($params['province_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `'.$modelRegency->getTable().'`.`province_id` = "'.$params['province_id'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['regency_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `'.$modelDistrict->getTable().'`.`regency_id` = "'.$params['regency_id'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['district_id'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `'.$model->getTable().'`.`district_id` = "'.$params['district_id'].'"';

            $isUseWhere = true;
        }

        if ( ! empty($params['area_table'])) {
            if ($isUseWhere) {
                $fromSql .= ' AND';
            }

            $fromSql .= ' `'.$model->getTable().'`.`id` IN (';
            $fromSql .= 'SELECT `village_id` FROM `'.$params['area_table'].'`';
            $fromSql .= ' WHERE `is_active` = 1';
            $fromSql .= ')';

            $isUseWhere = true;
        }

        $fromSql .= ' ORDER BY `'.$model->getTable().'`.`'.$params['order_by'].'` ASC';

        if ($limit > 0) {
            $fromSql .= ' limit '.$limit.' offset '.($page - 1) * $limit;
        }

        $fromSql .= ') o';

        $query = $model->select($model->getTable().'.id');

        if ( ! empty($params['regency_id'])) {
            $query->leftJoin(
                $modelDistrict->getTable(), 
                $model->getTable().'.district_id', 
                '=', 
                $modelDistrict->getTable().'.id'
            );
        }

        if ( ! empty($params['province_id'])) {
            $query->leftJoin(
                $modelRegency->getTable(), 
                $modelDistrict->getTable().'.regency_id', 
                '=', 
                $modelRegency->getTable().'.id'
            );
        }

        if ( ! empty($params['province_id'])) {
            $query->where($modelRegency->getTable().'.province_id', '=', $params['province_id']);
        }

        if ( ! empty($params['regency_id'])) {
            $query->where($modelDistrict->getTable().'.regency_id', '=', $params['regency_id']);
        }

        if ( ! empty($params['district_id'])) {
            $query->where($model->getTable().'.district_id', '=', $params['district_id']);
        }

        if ( ! empty($params['area_table'])) {
            $whereRaw = ' `'.$model->getTable().'`.`id` IN (';
            $whereRaw .= 'SELECT `village_id` FROM `'.$params['area_table'].'`';
            $whereRaw .= ' WHERE `is_active` = 1';
            $whereRaw .= ')';

            $query->whereRaw($whereRaw);
        }

        $this->total = $query->count();

        $select = [
            $model->getTable().'.*'
        ];
        if ( ! empty($params['regency_id'])) {
            $select[] = 'o.regency';
            $select[] = 'o.district';
        }

        $query = $model->newQuery()->select($select)
                    ->from($this->getDb()->raw($fromSql))
                    ->join($model->getTable(), $model->getTable().'.id', '=', 'o.id')
                    ->orderBy($model->getTable().'.'.$params['order_by'], 'ASC');

        unset($fromSql);
        unset($model);

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findVillage($id)
    {
        $item = $this->createModelVillage()->find($id);

        if ( ! is_object($item)) {
            throw new RecordNotFoundException('No item found');
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
     * Create a new instance of the model province.
     *
     * @return \App\Modules\Territory\Models\Province
     */
    private function createModelProvince()
    {
        return new $this->modelProvince;
    }

    /**
     * Create a new instance of the model regency.
     *
     * @return \App\Modules\Territory\Models\Regency
     */
    private function createModelRegency()
    {
        return new $this->modelRegency;
    }

    /**
     * Create a new instance of the model district.
     *
     * @return \App\Modules\Territory\Models\District
     */
    private function createModelDistrict()
    {
        return new $this->modelDistrict;
    }

    /**
     * Create a new instance of the model village.
     *
     * @return \App\Modules\Territory\Models\Village
     */
    private function createModelVillage()
    {
        return new $this->modelVillage;
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
