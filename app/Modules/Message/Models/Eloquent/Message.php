<?php

namespace App\Modules\Message\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\Message\Models\Message as MessageInterface;

class Message extends Model implements MessageInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'title', 
        'content', 
        'sender', 
        'phone', 
        'email'
    ];
}
