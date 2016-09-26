<?php

namespace App\Modules\File\Models\Eloquent;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use Storage;

use App\Modules\File\Models\File as FileInterface;

class File extends Model implements FileInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'object_type', 
        'object_id', 
        'author_id', 
        'storage', 
        'title', 
        'path', 
        'filename', 
        'extension', 
        'mime_type', 
        'size', 
        'is_backed_up', 
        'is_backed_up_at', 
        'is_file_missing'
    ];

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        if (Storage::exists($this->path.'/'.$this->filename)) {
            Storage::delete($this->path.'/'.$this->filename);
        }
        
        return parent::delete();
    }
}
