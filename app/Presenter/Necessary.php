<?php

namespace App\Presenter;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 * Author: Saddam Almahali <saddam.almahali@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Collection;

use App\Modules\Necessary\Models\Necessary as NecessaryContract;

use App\Services\File as FileService;

class Necessary extends Presenter
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
     * @param  NecessaryContract $necessary
     * @return void
     */
    public function __construct(NecessaryContract $necessary)
    {
        parent::__construct($necessary);
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
                    'object_type' => 'necessary', 
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
