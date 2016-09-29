<?php

namespace App\Presenter\Area;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Collection;

use App\Presenter\Presenter;
use App\Presenter\User;

use App\Modules\Area\Models\Status as StatusContract;

use App\Services\User as UserService;
use App\Services\File as FileService;

use App\Modules\User\RecordNotFoundException;

class Status extends Presenter
{
    /**
     * The title.
     *
     * @var string
     */
    protected $_title;

    /**
     * The file collection.
     *
     * @var \Collection
     */
    protected $_files;

    /**
     * The User.
     *
     * @var \App\Presenter\User
     */
    protected $_user;

    /**
     * Create the Presenter and store the object we are presenting.
     *
     * @param  StatusContract $status
     * @return void
     */
    public function __construct(StatusContract $status)
    {
        parent::__construct($status);
    }

    /**
     * Return the area title.
     *
     * @return string
     */
    public function presentTitle()
    {
        if (is_null($this->_title)) {
            $this->_title = $this->object->area->title;
        }
        
        return $this->_title;
    }

    /**
     * Return the files.
     *
     * @return \Collection
     */
    public function presentFiles()
    {
        if ( ! empty($this->object->id)) {
            if (is_null($this->_files)) {
                list($this->_files) = $this->getFileService()->search([
                    'object_type' => 'area_status', 
                    'object_id'   => $this->object->id
                ], 1, 0);
            }
        } else {
            $this->_files = new Collection();
        }

        return $this->_files;
    }

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

    /**
     * Return the file service instance.
     *
     * @return \App\Services\File
     */
    private function getFileService()
    {
        $service = new FileService();

        return $service;
    }
}
