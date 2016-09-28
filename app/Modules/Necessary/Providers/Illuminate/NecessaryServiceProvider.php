<?php

namespace App\Modules\Necessary\Providers\Illuminate;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 * Author: Saddam Almahali <saddam.almahali@gmail.com>.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use App\Modules\Necessary\Repository;
use App\Modules\Necessary\NecessaryRepository;

class NecessaryServiceProvider extends BaseServiceProvider
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
            return new NecessaryRepository(
                \App\Modules\Necessary\Models\Eloquent\Necessary::class
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
