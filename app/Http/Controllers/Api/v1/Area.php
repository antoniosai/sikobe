<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Dingo\Api\Routing\Helpers;

use App\Services\Area as AreaService;

use App\Presenter\Api\Area\Area as AreaPresenter;
use App\Presenter\Api\Area\Status as StatusPresenter;

use RuntimeException;
use App\Modules\Area\RecordNotFoundException;

class Area extends Controller
{
    use Helpers;

    /**
     * Return areas.
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $limit    = (int) $request->get('limit', 10);
        $page     = (int) $request->get('page', 1);
        $district = trim($request->get('district', ''));
        $village  = trim($request->get('village', ''));
        $search   = trim($request->get('search', ''));
        $include  = trim($request->get('include', ''));

        if ($district == 'all') {
            $district = '';
        }

        if ($village == 'all') {
            $village = '';
        }

        $result = $this->getService()->search([
            'district_id' => $district, 
            'village_id'  => $village
        ], $page, $limit);
        
        return $this->response->paginator(
            $result, 
            new AreaPresenter, 
            [
                'include' => $include
            ]
        );
    }

    /**
     * Return area statuses.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllStatuses(Request $request, $id)
    {
        $limit    = (int) $request->get('limit', 10);
        $page     = (int) $request->get('page', 1);
        $include  = trim($request->get('include', ''));

        $result = $this->getService()->searchStatus([
            'area_id' => $id
        ], $page, $limit);
        
        return $this->response->paginator(
            $result, 
            new StatusPresenter, 
            [
                'include' => $include
            ]
        );
    }

    /**
     * Return the service instance.
     *
     * @return \App\Services\Area
     */
    private function getService()
    {
        return new AreaService();
    }
}
