<?php

namespace App\Modules\User\Models;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface User
{
    /**
     * Check if user is Super Admin.
     *
     * @return boolean
    */
    public function isSuperAdmin();

    /**
     * Check if user is Relawan.
     *
     * @return boolean
    */
    public function isRelawan();

    /**
     * Returns the relationship between users and metadatas.
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
    */
    public function metas();

    /**
     * Returns the relationship between users and login activities.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function loginActivities();

    /**
     * Returns the relationship between users and groups.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
    */
    public function groups();

    /**
     * Returns the relationship between users and user groups.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function groupIds();

    /**
     * Check if user in a group.
     *
     * @param  string $name
     *
     * @return boolean
     */
    public function isInGroup($name);
}
