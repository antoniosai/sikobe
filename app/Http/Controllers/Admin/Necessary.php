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
use App\Services\Necessary as NecessaryService;
use App\Services\Area as AreaService;

use App\Presenter\Necessary as NecessaryPresenter;

use RuntimeException;
use App\Modules\Necessary\RecordNotFoundException;

class Necessary extends Controller
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
        $description    = trim($request->get('description'));

        $necessaryService = $this->getNecessaryService();

        $list = $necessaryService->search([
            'district_id' => $district, 
            'village_id'  => $village, 
	        'description' => $description
        ], $page, $limit);

        list($districts, $villages) = $this->getTerritories();

        return view('admin.necessary.list', [
            'filter' => [
                'district' => $district, 
                'village'  => $village, 
                'description'    => $description
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
        $necessaryService = $this->getNecessaryService();

        try {
            $data = $necessaryService->get($id);
        } catch (RecordNotFoundException $e) {
            if ($id > 0) {
                abort(404);
            } else {
                $data = $necessaryService->getEmptyModel();
            }
        } catch (RuntimeException $e) {
            abort(500);
        }

        list($districts, $villages) = $this->getTerritories();

        list($areas) = $this->getArea();

        Asset::add(elixir('assets/js/file-upload.js'), 'footer.specific.js');

        return view('admin.necessary.form', [
            // 'districts' => $districts, 
            'areas'     => $areas,
            // 'villages'  => $villages, 
            'data'      => new NecessaryPresenter($data)
        ]);
        // return view('admin.necessary.form');
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
        $service = $this->getNecessaryService();

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

        return redirect('/ctrl/necessary/'.$response->id);
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

        $service = $this->getNecessaryService();

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
        
        return redirect('/ctrl/necessary');
    }

    public function getArea(){
        $areaService = $this->getAreaService();

        list($areas) = $areaService->searchAreasList([
                'province_id' => $this->provinceId, 
                'regency_id'  => $this->regencyId,
                'order_by'=>'title'
            ], 1, 0);

        return [$areas];
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
     * Return the necessary service instance.
     *
     * @return \App\Services\Necessary
     */
    private function getNecessaryService()
    {
        $service = new NecessaryService();
        $service->setUser($this->user);

        return $service;
    }

    public function getAreaService(){
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
