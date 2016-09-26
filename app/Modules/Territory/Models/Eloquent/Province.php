<?php

namespace App\Modules\Territory\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\Territory\Models\Province as ProvinceInterface;

class Province extends Model implements ProvinceInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'provinces';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name'
    ];
}
