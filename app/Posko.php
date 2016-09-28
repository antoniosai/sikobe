<?php

namespace App;

/*
 * Author: Ikbal Mohamad Hikmat <hikmat.iqbal@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

class Posko extends Model
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
      'longitude'
  ];
}
