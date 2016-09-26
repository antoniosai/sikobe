<?php

namespace App\Http\Controllers\Admin;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Support\Asset;
use App\Services\Territory as TerritoryService;
use App\Services\Area as AreaService;

use RuntimeException;
use App\Modules\Territory\RecordNotFoundException;

class Area extends Controller
{
    /**
     * Current province ID.
     *
     * @var integer
     */
    protected $provinceId = 32;

    /**
     * Current regency ID.
     *
     * @var integer
     */
    protected $regencyId = 3205;

    /**
     * Show the items.
     *
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 10;
        $page  = (int) $request->get('page', 1);
        $district = (int) $request->get('district');
        $village  = (int) $request->get('village');
        $title    = trim($request->get('title'));

        $areaService = $this->getAreaService();
        $territoryService = $this->getTerritoryService();

        list($collection, $total) = $areaService->search([
            'district_id' => $district, 
            'village_id'  => $village, 
            'title'       => $title
        ], $page, $limit);
        
        $list = new LengthAwarePaginator(
            $collection->all(), 
            $total, 
            $limit, 
            $page, 
            ['path' => Paginator::resolveCurrentPath()]
        );

        list($districts) = $territoryService->searchDistricts([
            'province_id' => $this->provinceId, 
            'regency_id'  => $this->regencyId, 
            'order_by'    => 'name'
        ], 1, 0);

        list($villages) = $territoryService->searchVillages([
            'province_id' => $this->provinceId, 
            'regency_id'  => $this->regencyId, 
            'order_by'    => 'name'
        ], 1, 0);

        return view('admin.areas', [
            'filter' => [
                'district' => $district, 
                'village'  => $village, 
                'title'    => $title
            ], 
            'districts' => $districts, 
            'villages'  => $villages, 
            'list'      => $list
        ]);
    }

    /**
     * Delete a item.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer                  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        // You can implement this later
        if (Gate::denies('delete', $this)) {
            abort(403);
        }

        if (empty($id)) {
            abort(404);
        }

        $service = $this->getService();

        try {
            $isDeleted = $service->delete($id);
        } catch (RecordNotFoundException $e) {
            abort(404);
        }

        if ( ! $isDeleted) {
            $request->session()->flash('error', 'Terjadi kesalahan ketika menghapus!');
        } else {
            $request->session()->flash('success', 'Berhasil dihapus!');
        }

        return back();
    }

    /**
     * Create new item.
     *
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // You can implement this later
        if (Gate::denies('create', $this)) {
            abort(403);
        }

        $service = $this->getService();

        try {
            $response = $service->create();

            if ($response instanceOf Validator) {
                $request->session()->flash('error', 'Tolong perbaiki input dengan tanda merah!');

                $this->throwValidationException(
                    $request, $response
                );
            }
        } catch (RuntimeException $e) {
            abort(500);
        }

        $request->session()->flash('success', 'Berhasil tersimpan!');

        return back();
    }

    /**
     * Save a item.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Integer                  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id)
    {
        // You can implement this later
        if (Gate::denies('update', $this)) {
            abort(403);
        }

        $service = $this->getService();

        try {
            $response = $service->save($id);

            if ($response instanceOf Validator) {
                $request->session()->flash('error', 'Tolong perbaiki input dengan tanda merah!');

                $this->throwValidationException(
                    $request, $response
                );
            }
        } catch (RecordNotFoundException $e) {
            abort(404);
        } catch (RuntimeException $e) {
            abort(500);
        }

        $request->session()->flash('success', 'Berhasil tersimpan!');

        return back();
    }

    /**
     * Return the area service instance.
     *
     * @return \App\Services\Area
     */
    private function getAreaService()
    {
        $service = new AreaService();

        return $service;
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
}
