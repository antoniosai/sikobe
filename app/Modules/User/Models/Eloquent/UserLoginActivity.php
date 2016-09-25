<?php

namespace App\Modules\User\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\User\Models\UserLoginHistory as UserLoginHistoryInterface;

class UserLoginActivity extends Model implements UserLoginHistoryInterface
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'users_login_history';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id', 
        'ip_address', 
        'country_code', 
        'country_name', 
        'os_family', 
        'is_mobile', 
        'is_tablet', 
        'is_desktop', 
        'browser_family', 
        'browser_version_major', 
        'browser_version_minor', 
        'browser_version_patch', 
        'device_family', 
        'device_model', 
        'is_saved', 
        'last_activity'
    ];

}
