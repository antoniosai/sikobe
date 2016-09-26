<?php

namespace App\Modules\Territory\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\Territory\Models\Village as VillageInterface;

class Village extends Model implements VillageInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'villages';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'district_id', 
        'name'
    ];

    /**
     * {@inheritdoc}
     */
    public function district()
    {
        return $this->belongsTo('\App\Modules\Territory\Models\Eloquent\District');
    }
}
