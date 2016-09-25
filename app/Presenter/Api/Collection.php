<?php

namespace App\Presenter\Api;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use League\Fractal\TransformerAbstract;

use App\Modules\Collection\Models\Collection as CollectionContract;

class Collection extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param  CollectionContract $item
     *
     * @return array
     */
    public function transform(CollectionContract $item)
    {
        return [
            'id'          => (int) $item->id, 
            'identifier'  => $item->identifier, 
            'title'       => $item->title, 
            'description' => $item->description, 
            'created_at'  => $item->created_at, 
            'links'       => [
                [
                    'rel' => 'self',
                    'uri' => '/'.$item->identifier.'s/'.$item->id,
                ]
            ]
        ];
    }

}
