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

use App\Support\Asset;
use App\Services\Territory as TerritoryService;
use App\Services\Area as AreaService;

use App\Presenter\Area as AreaPresenter;

use RuntimeException;
use App\Modules\Area\RecordNotFoundException;

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
        $limit    = 10;
        $page     = (int) $request->get('page', 1);
        $district = (int) $request->get('district');
        $village  = (int) $request->get('village');
        $title    = trim($request->get('title'));

        $areaService = $this->getAreaService();

        $list = $areaService->search([
            'district_id' => $district,
            'village_id'  => $village,
            'title'       => $title
        ], $page, $limit);

        list($districts, $villages) = $this->getTerritories();

        return view('admin.area.list', [
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
     * Show the form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Request $request, $id = 0)
    {
        $areaService = $this->getAreaService();

        try {
            $data = $areaService->get($id);
        } catch (RecordNotFoundException $e) {
            if ($id > 0) {
                abort(404);
            } else {
                $data = $areaService->getEmptyModel();
            }
        } catch (RuntimeException $e) {
            abort(500);
        }

        list($districts, $villages) = $this->getTerritories();

        Asset::add(elixir('assets/js/file-upload.js'), 'footer.specific.js');

        return view('admin.area.form', [
            'districts' => $districts,
            'villages'  => $villages,
            'data'      => new AreaPresenter($data)
        ]);
    }

    /**
     * Save a item.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Integer                  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id = 0)
    {
        $service = $this->getAreaService();

        try {
            $response = $service->save($id, [
                'province_id' => $this->provinceId,
                'regency_id'  => $this->regencyId,
            ]);

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

        return redirect('/ctrl/areas/'.$response->id);
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
        if (empty($id)) {
            abort(404);
        }

        $service = $this->getAreaService();

        try {
            $isDeleted = $service->delete($id);
        } catch (RecordNotFoundException $e) {
            abort(404);
        }

        if ( ! $isDeleted) {
            $request->session()->flash('error', 'Terjadi kesalahan ketika menghapus!');

            return back();
        }

        $request->session()->flash('success', 'Berhasil dihapus!');

        return redirect('/ctrl/areas');
    }

    /**
     * Return all required territories.
     *
     * @return array
     */
    private function getTerritories()
    {
        $territoryService = $this->getTerritoryService();

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

        return [$districts, $villages];
    }

    /**
     * Return the area service instance.
     *
     * @return \App\Services\Area
     */
    private function getAreaService()
    {
        $service = new AreaService();
        $service->setUser($this->user);

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
