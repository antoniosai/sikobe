<?php

namespace App\Presenter;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Services\User as UserService;

use App\Modules\Collection\Models\Collection as CollectionContract;

use App\Modules\User\RecordNotFoundException;

class Collection extends Presenter
{
    /**
     * The User.
     *
     * @var \App\Presenter\User
     */
    protected $_user;

    /**
     * Return the user.
     *
     * @return \Collection
     */
    public function presentAuthor()
    {
        if (is_null($this->_user)) {
            $service = new UserService();

            try {
                $this->_user = new User($service->get($this->object['author_id']));
            } catch (RecordNotFoundException $e) {}
        }
        
        return $this->_user;
    }

}
