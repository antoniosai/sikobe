<?php

namespace App\Presenter\Api;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Support\Str;

use League\Fractal\TransformerAbstract;

use App\Modules\File\Models\File as FileContract;

class File extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @param  FileContract $item
     *
     * @return array
     */
    public function transform(FileContract $item)
    {
        return [
            'title'      => $item->title, 
            'url'        => env('APP_URL').'/storage/'.$item->filename, 
            'created_at' => $item->created_at
        ];
    }

}
