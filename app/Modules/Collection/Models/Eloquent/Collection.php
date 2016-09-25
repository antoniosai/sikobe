<?php

namespace App\Modules\Collection\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\Collection\Models\Collection as CollectionInterface;

class Collection extends Model implements CollectionInterface
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
}
