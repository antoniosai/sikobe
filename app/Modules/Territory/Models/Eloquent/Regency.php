<?php

namespace App\Modules\Territory\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\Territory\Models\Regency as RegencyInterface;

class Regency extends Model implements RegencyInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regencies';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'province_id',
        'name'
    ];

    public function province()
    {
        return $this->belongsTo('\App\Modules\Territory\Models\Eloquent\Province');
    }
}
