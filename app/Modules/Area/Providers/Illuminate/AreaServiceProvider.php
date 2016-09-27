<?php

namespace App\Modules\Area\Providers\Illuminate;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use App\Modules\Area\Repository;
use App\Modules\Area\AreaRepository;

class AreaServiceProvider extends BaseServiceProvider
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
            return new AreaRepository(
                \App\Modules\Area\Models\Eloquent\Area::class, 
                \App\Modules\Area\Models\Eloquent\Status::class
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
