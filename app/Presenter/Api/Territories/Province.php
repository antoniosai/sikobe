<?php

namespace App\Presenter\Api\Territories;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Support\Str;

use League\Fractal\TransformerAbstract;

use App\Modules\Territory\Models\Province as ProvinceContract;

class Province extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param  ProvinceContract $item
     *
     * @return array
     */
    public function transform(ProvinceContract $item)
    {
        return [
            'id'    => $item->id, 
            'title' => $item->name
        ];
    }

}
