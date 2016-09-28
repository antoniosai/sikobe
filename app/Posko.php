<?php

namespace App;

/*
 * Author: Ikbal Mohamad Hikmat <hikmat.iqbal@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

use App\Modules\CommandPost\Models\CommandPost;

class Posko extends Model implements CommandPost
{

  protected $table = 'posko';

  protected $fillable = [
      'title',
      'address',
      'village_id',
      'leader',
      'phone',
      'area_id',
      'latitude',
      'longitude',
      'author_id'
  ];

    /**
     * Get the area that owns the posko.
     */
    public function village()
    {
        return $this->belongsTo('\App\Modules\Territory\Models\Eloquent\Village');
    }

    /**
     * Get the area that owns the posko.
     */
    public function area()
    {
        return $this->belongsTo('\App\Modules\Area\Models\Eloquent\Area');
    }

    /**
     * Get the area that owns the posko.
     */
    public function files()
    {
        return $this->hasMany('\App\Modules\File\Models\Eloquent\File', 'object_id');
    }
}
