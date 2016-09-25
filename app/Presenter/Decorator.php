<?php

namespace App\Presenter;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Contracts\Presentable;
use ArrayAccess, IteratorAggregate;

class Decorator
{

    /*
     * If this variable implements App\Contracts\Presentable
     * then turn it into a presenter.
     *
     * @param  mixed $value
     * @return mixed $value
     */
    public function decorate($value)
    {
        if ($value instanceof Presentable) {
            return $value->getPresenter();
        }

        if (is_array($value) or ($value instanceof IteratorAggregate and $value instanceof ArrayAccess)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->decorate($v);
            }
        }

        return $value;
    }
  
}