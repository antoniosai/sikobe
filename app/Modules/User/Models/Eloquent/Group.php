<?php

namespace App\Modules\User\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\User\Models\Group as GroupInterface;

class Group extends Model implements GroupInterface
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'groups';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name', 
        'permissions'
    ];

}
