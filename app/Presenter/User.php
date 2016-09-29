<?php

namespace App\Presenter;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\User\Models\User as UserContract;

class User extends Presenter
{
    /**
     * The groups.
     *
     * @var array
     */
    protected $_groups;

    /**
     * Create the Presenter and store the object we are presenting.
     *
     * @param  UserContract $user
     * @return void
     */
    public function __construct(UserContract $user)
    {
        parent::__construct($user);

        $metas = $user->metas()->getResults();

        if ( ! $metas->isEmpty()) {
            foreach ($metas as $item) {
                $this->object[$item->handle] = $item->value;
            }
        }

        unset($metas);
    }

    /**
     * Return the user full name.
     *
     * @return string
     */
    public function presentName()
    {
        return $this->object['display_name'];
    }

    /**
     * Return the user groups.
     *
     * @return \Collection
     */
    public function presentGroups()
    {
        if (is_null($this->_groups)) {
            $this->_groups = $this->object->groups->map(function($item) {
                return new Group($item);
            });
        }
        
        return $this->_groups;
    }

}
