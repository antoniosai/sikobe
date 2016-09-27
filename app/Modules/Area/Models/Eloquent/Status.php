<?php

namespace App\Modules\Area\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\Area\Models\Status as StatusInterface;

use App\Presenter\Area\Status as StatusPresenter;
use App\Contracts\Presentable;

class Status extends Model implements StatusInterface, Presentable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas_statuses';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'identifier', 
        'area_id', 
        'author_id', 
        'description', 
        'scale', 
        'datetime'
    ];

    /**
     * {@inheritdoc}
     */
    public function area()
    {
        return $this->belongsTo('\App\Modules\Area\Models\Eloquent\Area');
    }

    /**
     * {@inheritdoc}
     */
    public function getPresenter()
    {
        return new StatusPresenter($this);
    }
}
