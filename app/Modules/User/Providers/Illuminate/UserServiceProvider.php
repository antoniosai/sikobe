<?php

namespace App\Modules\User\Providers\Illuminate;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use App\Modules\User\Repository;
use App\Modules\User\UserRepository;

class UserServiceProvider extends BaseServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton(Repository::class, function() {
            return new UserRepository(
                \App\User::class, 
                \App\Modules\User\Models\Eloquent\UserMeta::class, 
                \App\Modules\User\Models\Eloquent\Group::class, 
                \App\Modules\User\Models\Eloquent\UserGroup::class
            );
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [Repository::class];
    }
}
