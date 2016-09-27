<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\Area\Repository;

use Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Uuid;

use App\Services\Territory as TerritoryService;
use App\Services\File as FileService;

use App\Services\Validators\Area as AreaValidator;

use RuntimeException;
use App\Modules\Area\RecordNotFoundException;

class Area extends Service
{
    /**
     * Search items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return array
     * @throws \RuntimeException
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        $repository = $this->getAreaRepository();
        $collection = $repository->search($params, $page, $limit);

        return new LengthAwarePaginator(
            $collection->all(), 
            $repository->getTotal(), 
            ($limit > 0) ? $limit : 1, 
            $page, 
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * Search status items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     * 
     * @return array
     * @throws \RuntimeException
     */
    public function searchStatus(Array $params = [], $page = 1, $limit = 10)
    {
        $repository = $this->getAreaRepository();
        $collection = $repository->searchStatus($params, $page, $limit);
        
        return new LengthAwarePaginator(
            $collection->all(), 
            $repository->getTotal(), 
            ($limit > 0) ? $limit : 1, 
            $page, 
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * Save a item.
     *
     * @param  integer $id
     * @param  array   $data
     * 
     * @return \Illuminate\Validation\Validator|mixed
     * @throws \App\Modules\Area\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function save($id, Array $data = [])
    {
        if (is_null($this->user)) {
            throw new RuntimeException('User information is required');
        }

        // Validate request data
        $validator = $this->getValidator();

        if (true !== ($validation = $validator->isValid())) {
            return $validation;
        }

        if ( ! empty($id)) {
            $area = $this->get($id);
        }
        
        $request = $this->getRequest();

        $villageId = trim($request->get('village'));
        $village = $this->getTerritoryService()->getVillage($villageId);

        $data = array_merge([
            'title'       => trim($request->get('title')), 
            'description' => $request->get('description'), 
            'address'     => trim($request->get('address')), 
            'district_id' => $village->district_id, 
            'village_id'  => $villageId, 
            'latitude'    => (float) $request->get('latitude'), 
            'longitude'   => (float) $request->get('longitude'), 
            'status'      => trim($request->get('status'))
        ], $data);

        // Save
        if ( ! empty($id)) {
            $area->fill($data);
            $area->save();
        } else {
            $data = array_merge([
                'identifier' => Uuid::generate(5, $data['title'], Uuid::NS_DNS), 
                'author_id'  => $this->user->id
            ], $data);

            $area = $this->getAreaRepository()->create($data);
        }

        $this->processFiles($area, 'area');

        return $area;
    }

    /**
     * Save a status item.
     *
     * @param  integer $areaId
     * @param  integer $id
     * 
     * @return \Illuminate\Validation\Validator|mixed
     * @throws \App\Modules\Area\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function saveStatus($areaId, $id)
    {
        if (is_null($this->user)) {
            throw new RuntimeException('User information is required');
        }

        // Validate request data
        $validator = $this->getValidator();

        if (true !== ($validation = $validator->isValidStatus())) {
            return $validation;
        }

        if ( ! empty($id)) {
            $status = $this->getStatus($id);
        }

        $data = [
            'description' => $this->getRequest()->get('description'), 
            'scale'       => (int) $this->getRequest()->get('scale'), 
            'datetime'    => $this->getRequest()->get('datetime')
        ];

        if (empty($data['datetime'])) {
            $data['datetime'] = (new \DateTime())->format('Y-m-d H:i:s');
        }

        // Save
        if ( ! empty($id)) {
            $status->fill($data);
            $status->save();
        } else {
            $data = array_merge([
                'identifier' => Uuid::generate(5, $data['datetime'], Uuid::NS_DNS), 
                'area_id'    => $areaId, 
                'author_id'  => $this->user->id
            ], $data);

            $status = $this->getAreaRepository()->createStatus($data);
        }

        $this->processFiles($status, 'area_status');

        return $status;
    }

    /**
     * Process the item files.
     *
     * @param  mixed   $object
     * @param  string  $objectType
     * 
     * @return \Illuminate\Validation\Validator|mixed
     * @throws \App\Modules\Area\RecordNotFoundException
     * @throws \RuntimeException
     */
    private function processFiles($object, $objectType)
    {
        $fileService = $this->getFileService();

        // Remove files
        $keepFiles = $this->getRequest()->get('keep-files', []);

        list($existingFiles) = $fileService->search([
            'object_type' => $objectType, 
            'object_id'   => $object->id
        ], 1, 0);

        if ( ! $existingFiles->isEmpty()) {
            foreach ($existingFiles as $file) {
                if ( ! in_array($file->id, $keepFiles)) {
                    // $file->delete();
                    $file->is_active = 0;
                    $file->save();
                }
            }
        }

        // Save files
        $files = $this->getRequest()->file('files');

        if (count($files) > 0) {
            foreach ($files as $file) {
                if ($file instanceOf \SplFileInfo) {
                    if ($file->isValid()) {
                        $rawName = $objectType.'-'.$object->id;
                        $rawName .= '-'.str_replace(' ', '-', microtime());
                        $rawName .= '-'.sha1_file($file->getPathname());

                        $data = [
                            'object_type' => $objectType, 
                            'object_id'   => $object->id, 
                            'author_id'   => $this->user->id, 
                            'title'       => $file->getClientOriginalName(), 
                            'path'        => config('sikobe.path.files.folder'), 
                            'filename'    => $rawName.'.'.$file->getClientOriginalExtension(), 
                            'extension'   => $file->getClientOriginalExtension(), 
                            'mime_type'   => $file->getClientMimeType(), 
                            'size'        => $file->getClientSize()
                        ];

                        if (Storage::disk('local')->put($data['path'].'/'.$data['filename'], \File::get($file))) {
                            $fileService->create($data);
                        }
                    }
                }
            }
        }
    }

    /**
     * Delete a item.
     *
     * @param  integer $id
     * 
     * @return boolean
     * @throws \App\Modules\Area\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function delete($id)
    {
        $area = $this->get($id);

        $area->is_active = 0;
        return $area->save();

        // list($existingFiles) = $this->getFileService()->search([
        //     'object_type' => 'area', 
        //     'object_id'   => $area->id
        // ], 1, 0);

        // if ( ! $existingFiles->isEmpty()) {
        //     foreach ($existingFiles as $file) {
        //         $file->delete();
        //     }
        // }

        // return $area->delete();
    }

    /**
     * Delete a status item.
     *
     * @param  integer $areaId
     * @param  integer $id
     * 
     * @return boolean
     * @throws \App\Modules\Area\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function deleteStatus($areaId, $id)
    {
        $status = $this->getStatus($id);

        if ($status->area_id != $areaId) {
            throw new RecordNotFoundException('Item not found');
        }

        $status->is_active = 0;
        return $status->save();

        // list($existingFiles) = $this->getFileService()->search([
        //     'object_type' => 'area_status', 
        //     'object_id'   => $status->id
        // ], 1, 0);

        // if ( ! $existingFiles->isEmpty()) {
        //     foreach ($existingFiles as $file) {
        //         $file->delete();
        //     }
        // }

        // return $status->delete();
    }

    /**
     * Return a item.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Area\Models\Area
     * @throws \App\Modules\Area\RecordNotFoundException
     */
    public function get($id)
    {
        return $this->getAreaRepository()->find($id);
    }

    /**
     * Return item photos.
     *
     * @param  integer $id
     * 
     * @return \Collection
     * @throws \App\Modules\Area\RecordNotFoundException
     */
    public function getPhotos($id)
    {
        $area = $this->get($id);

        list($files) = $this->getFileService()->search([
            'object_type' => 'area', 
            'object_id'   => $area->id
        ], 1, 0);

        return $files;
    }

    /**
     * Return a status item.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Area\Models\Status
     * @throws \App\Modules\Area\RecordNotFoundException
     */
    public function getStatus($id)
    {
        return $this->getAreaRepository()->findStatus($id);
    }

    /**
     * Return a empty model.
     * 
     * @return \App\Modules\Area\Models\Area
     */
    public function getEmptyModel()
    {
        return $this->getAreaRepository()->createModel();
    }

    /**
     * Return a empty status model.
     * 
     * @return \App\Modules\Area\Models\Status
     */
    public function getEmptyModelStatus()
    {
        return $this->getAreaRepository()->createModelStatus();
    }

    /**
     * Return validator instance.
     *
     * @return \App\Services\Validators\Area
     */
    private function getValidator()
    {
        return new AreaValidator($this->getRequest());
    }

    /**
     * Return the territory service instance.
     *
     * @return \App\Services\Territory
     */
    private function getTerritoryService()
    {
        $service = new TerritoryService();

        return $service;
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

    /**
     * Return Area instance.
     *
     * @return \App\Modules\Area\Repository
     */
    private function getAreaRepository()
    {
        return app(Repository::class);
    }
}
