<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Validation\Validator;

use App\Services\Service;
use App\Services\Validators\Collection as CollectionValidator;

use App\Modules\Collection\Repository;

use RuntimeException;

class Collection extends Service
{
    /**
     * Search black list items.
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
        $repository = $this->getCollectionRepository();
        $collection = $repository->search($params, $page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Delete a collection item.
     *
     * @param  integer $id
     *
     * @return boolean
     * @throws \App\Modules\Collection\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function delete($id)
    {
        $item = $this->getCollectionRepository()->find($id);

        return $item->delete();
    }

    /**
     * Update the Information.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function informasiUpdate($id)
    {
      $validator = $this->getValidator();

      $request = $this->getRequest();

      $collectionRepository = $this->getCollectionRepository();

      $item = $collectionRepository->findBy(['id' => $id]);

      $data = [
          'author_id'      => $request->get('author_id'),
          'identifier'  => $request->get('identifier'),
          'description' => $request->get('description')
      ];

      $item->fill($data);

      if ( ! $item->save()) {
          throw new RuntimeException('Failed to update information');
      }

      return $item;

    }

    /**
     * Create new item.
     *
     * @param  string  $identifier
     *
     * @return \Illuminate\Validation\Validator|App\Modules\Collection\Models\Collection
     * @throws \RuntimeException
     */
    public function create($identifier)
    {
        // Validate request data
        $validator = $this->getValidator();

        if (true !== ($validation = $validator->isValid())) {
            return $validation;
        }

        $request = $this->getRequest();

        return $this->getCollectionRepository()->create([
            'author_id'   => $request->get('author_id'),
            'identifier'  => $identifier,
            'title'       => $request->get('title'),
            'description' => $request->get('description')
        ]);
    }

    /**
     * Return validator instance.
     *
     * @return \App\Services\Validators\Preferences\Collection
     */
    private function getValidator()
    {
        return new CollectionValidator($this->getRequest());
    }

    /**
     * Return Collection instance.
     *
     * @return \App\Modules\Collection\Repository
     */
    private function getCollectionRepository()
    {
        return app(Repository::class);
    }
}
