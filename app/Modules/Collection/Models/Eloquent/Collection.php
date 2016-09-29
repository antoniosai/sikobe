<?php

namespace App\Modules\Collection\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Presenter\Collection as CollectionPresenter;
use App\Contracts\Presentable;

use App\Modules\Collection\Models\Collection as CollectionInterface;

class Collection extends Model implements CollectionInterface, Presentable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'author_id',
        'identifier',
        'title',
        'description'
    ];

    /**
     * {@inheritdoc}
     */
    public function getPresenter()
    {
        return new CollectionPresenter($this);
    }
}
