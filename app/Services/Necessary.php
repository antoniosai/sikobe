<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 * Author: Saddam Almahali <saddam.almahali@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Modules\Necessary\Repository;

use Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Uuid;

use App\Services\Territory as TerritoryService;
use App\Services\File as FileService;

use App\Services\Validators\Necessary as NecessaryValidator;

use RuntimeException;

class Necessary extends Service
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
        $repository = $this->getNecessaryRepository();
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
     * @throws \App\Modules\Necessary\RecordNotFoundException
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
            $necessary = $this->get($id);
        }
        
        $request = $this->getRequest();

        $villageId = trim($request->get('village'));
        $village = $this->getTerritoryService()->getVillage($villageId);

        $data = array_merge([
            'description' => $request->get('description'), 
            'district_id' => $village->district_id, 
            'village_id'  => $villageId, 
            
            'status'      => trim($request->get('status'))
        ], $data);

        // Save
        if ( ! empty($id)) {
            $necessary->fill($data);
            $necessary->save();
        } else {
            $data = array_merge([
                'identifier'  => Uuid::generate(5, $request->get('title'), Uuid::NS_DNS), 
                'author_id'   => $this->user->id
            ], $data);

            $necessary = $this->getNecessaryRepository()->create($data);
        }

        

        return $necessary;
    }

    /**
     * Delete a item.
     *
     * @param  integer $id
     * 
     * @return boolean
     * @throws \App\Modules\Necessary\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function delete($id)
    {
        $necessary = $this->get($id);

        

        return $necessary->delete();
    }

    /**
     * Return a item.
     *
     * @param  integer $id
     * 
     * @return \App\Modules\Necessary\Models\Necessary
     * @throws \App\Modules\Necessary\RecordNotFoundException
     */
    public function get($id)
    {
        return $this->getNecessaryRepository()->find($id);
    }

    /**
     * Return a empty model.
     * 
     * @return \App\Modules\Necessary\Models\Necessary
     */
    public function getEmptyModel()
    {
        return $this->getNecessaryRepository()->createModel();
    }

    /**
     * Return validator instance.
     *
     * @return \App\Services\Validators\Necessary
     */
    private function getValidator()
    {
        return new NecessaryValidator($this->getRequest());
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
     * Return Necessary instance.
     *
     * @return \App\Modules\Necessary\Repository
     */
    private function getNecessaryRepository()
    {
        return app(Repository::class);
    }
}
