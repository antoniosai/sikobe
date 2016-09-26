<?php

namespace App\Modules\Territory\Providers\Illuminate;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use App\Modules\Territory\Repository;
use App\Modules\Territory\TerritoryRepository;

class TerritoryServiceProvider extends BaseServiceProvider
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
            return new TerritoryRepository(
                \App\Modules\Territory\Models\Eloquent\Province::class, 
                \App\Modules\Territory\Models\Eloquent\Regency::class, 
                \App\Modules\Territory\Models\Eloquent\District::class, 
                \App\Modules\Territory\Models\Eloquent\Village::class
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
