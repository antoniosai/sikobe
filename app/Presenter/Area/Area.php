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

use App\Modules\Area\Models\Area as AreaContract;

use App\Services\File as FileService;

class Area extends Presenter
{
    /**
     * The file collection.
     *
     * @var \Collection
     */
    protected $_files;

    /**
     * Create the Presenter and store the object we are presenting.
     *
     * @param  AreaContract $area
     * @return void
     */
    public function __construct(AreaContract $area)
    {
        parent::__construct($area);
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
                    'object_type' => 'area', 
                    'object_id'   => $this->object->id
                ], 1, 0);
            }
        } else {
            $this->_files = new Collection();
        }

        return $this->_files;
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
