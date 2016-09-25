<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Dingo\Api\Routing\Helpers;

use App\Services\Collection as CollectionService;

use App\Presenter\Api\Collection as CollectionPresenter;

use RuntimeException;
use App\Modules\Collection\RecordNotFoundException;

class Information extends Controller
{
    use Helpers;

    /**
     * Return the all information.
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $identifier = 'information';
        $limit      = (int) $request->get('limit', 10);
        $page       = (int) $request->get('page', 1);

        list($collection, $total) = $this->getService()->search([
            'identifier' => $identifier
        ], $page, $limit);

        $paginator = new LengthAwarePaginator(
            $collection->all(), 
            $total, 
            $limit, 
            $page, 
            ['path' => Paginator::resolveCurrentPath()]
        );
        
        return $this->response->paginator(
            $paginator, 
            new CollectionPresenter
        );
    }

    /**
     * Return the service instance.
     *
     * @return \App\Services\Todo
     */
    private function getService()
    {
        return new CollectionService();
    }
}
