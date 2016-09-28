<?php

namespace App\Modules\Necessary\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 * Author: Saddam Almahali <saddam.almahali@gmail.com>.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\Necessary\Models\Necessary as NecessaryInterface;

use App\Presenter\Necessary as NecessaryPresenter;
use App\Contracts\Presentable;

class Necessary extends Model implements NecessaryInterface, Presentable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'necessary';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'identifier',   
        'author_id', 
        'title', 
        'description', 
        'address', 
        'province_id', 
        'regency_id', 
        'district_id', 
        'village_id', 
        'latitude', 
        'longitude', 
        'status'
    ];

    /**
     * {@inheritdoc}
     */
    public function getPresenter()
    {
        return new NecessaryPresenter($this);
    }
}
