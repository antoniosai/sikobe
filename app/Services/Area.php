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
            $limit, 
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
                'identifier'  => Uuid::generate(5, $request->get('title'), Uuid::NS_DNS), 
                'author_id'   => $this->user->id
            ], $data);

            $area = $this->getAreaRepository()->create($data);
        }

        $fileService = $this->getFileService();

        // Remove files
        $keepFiles = $request->get('keep-files', []);

        list($existingFiles) = $fileService->search([
            'object_type' => 'area', 
            'object_id'   => $area->id
        ], 1, 0);

        if ( ! $existingFiles->isEmpty()) {
            foreach ($existingFiles as $file) {
                if ( ! in_array($file->id, $keepFiles)) {
                    $file->delete();
                }
            }
        }

        // Save files
        $files = $request->file('files');

        if (count($files) > 0) {
            foreach ($files as $file) {
                if ($file instanceOf \SplFileInfo) {
                    if ($file->isValid()) {
                        $rawName = 'area-'.$area->id;
                        $rawName .= '-'.str_replace(' ', '-', microtime());
                        $rawName .= '-'.sha1_file($file->getPathname());

                        $data = [
                            'object_type' => 'area', 
                            'object_id'   => $area->id, 
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

        return $area;
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

        list($existingFiles) = $this->getFileService()->search([
            'object_type' => 'area', 
            'object_id'   => $area->id
        ], 1, 0);

        if ( ! $existingFiles->isEmpty()) {
            foreach ($existingFiles as $file) {
                $file->delete();
            }
        }

        return $area->delete();
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
     * Return a empty model.
     * 
     * @return \App\Modules\Area\Models\Area
     */
    public function getEmptyModel()
    {
        return $this->getAreaRepository()->createModel();
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
