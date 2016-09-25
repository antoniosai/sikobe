<?php

namespace App\Modules\Geo\Providers\Illuminate;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use App\Modules\Geo\Location;

class GeoServiceProvider extends BaseServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton(Location::class, function($app) {
            $driver = trim($app['config']->get('geo.driver'));
            $props  = $app['config']->get('geo.'.$driver);

            return new Location($driver, $props);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [Location::class];
    }
}
