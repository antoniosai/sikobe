<?php

namespace App;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use DB;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Presenter\User as UserPresenter;
use App\Contracts\Presentable;

use App\Modules\User\Models\User as UserContract;

class User extends Authenticatable implements UserContract, Presentable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Is the super admin.
     *
     * @var boolean
     */
    protected $_isSuperAdmin;

    /**
     * Is the relawan.
     *
     * @var boolean
     */
    protected $_isRelawan;

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $metas = $this->metas;

        if ( ! $metas->isEmpty()) {
            foreach ($metas as $meta) {
                $meta->delete();
            }
        }

        $groupIds = $this->groupIds;

        if ( ! $groupIds->isEmpty()) {
            foreach ($groupIds as $groupId) {
                DB::table($groupId->getTable())
                    ->where('user_id', '=', $groupId->user_id)
                    ->where('group_id', '=', $groupId->group_id)
                    ->delete();
            }
        }

        return parent::delete();
    }

    /**
     * {@inheritdoc}
     */
    public function isSuperAdmin()
    {
        if (is_null($this->_isSuperAdmin)) {
            $this->_isSuperAdmin = $this->isInGroup('Administrators');
        }

        return $this->_isSuperAdmin;
    }

    /**
     * {@inheritdoc}
     */
    public function isRelawan()
    {
        if (is_null($this->_isRelawan)) {
            $this->_isRelawan = $this->isInGroup('Relawan');
        }

        return $this->_isRelawan;
    }

    /**
     * {@inheritdoc}
     */
    public function metas()
    {
        return $this->hasMany('\App\Modules\User\Models\Eloquent\UserMeta');
    }

    /**
     * {@inheritdoc}
     */
    public function loginActivities()
    {
        return $this->hasMany('\App\Modules\User\Models\Eloquent\UserLoginActivity', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function groups()
    {
        return $this->hasManyThrough(
            '\App\Modules\User\Models\Eloquent\Group', 
            '\App\Modules\User\Models\Eloquent\UserGroup', 
            'user_id', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function groupIds()
    {
        return $this->hasMany('\App\Modules\User\Models\Eloquent\UserGroup', 'user_id');
    }

    /**
     * Check if user in a group.
     *
     * @param  string $name
     *
     * @return boolean
     */
    public function isInGroup($name)
    {
        $groups = $this->groups;
        
        if ( ! is_null($groups)) {
            if ( ! $groups->isEmpty()) {
                $result = $groups->search(function ($item) use ($name) {
                    return $item->name == $name;
                });

                if (is_bool($result)) {
                    return false;
                }

                return true;
            }
        }

        unset($groups);

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresenter()
    {
        return new UserPresenter($this);
    }
}
