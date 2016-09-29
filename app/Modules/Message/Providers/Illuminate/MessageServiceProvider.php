<?php

namespace App\Modules\Message\Providers\Illuminate;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use App\Modules\Message\Repository;
use App\Modules\Message\MessageRepository;

class MessageServiceProvider extends BaseServiceProvider
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
            return new MessageRepository(
                \App\Modules\Message\Models\Eloquent\Message::class
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
