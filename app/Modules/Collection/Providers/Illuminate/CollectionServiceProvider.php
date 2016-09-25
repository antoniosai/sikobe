<?php

namespace App\Modules\Collection\Providers\Illuminate;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use App\Modules\Collection\Repository;
use App\Modules\Collection\CollectionRepository;

class CollectionServiceProvider extends BaseServiceProvider
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
            return new CollectionRepository(
                \App\Modules\Collection\Models\Eloquent\Collection::class
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
