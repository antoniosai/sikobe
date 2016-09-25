<?php

namespace App\Modules\User\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\User\Models\UserMeta as UserMetaInterface;

class UserMeta extends Model implements UserMetaInterface
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'users_metas';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id', 
        'handle', 
        'value'
    ];

}
