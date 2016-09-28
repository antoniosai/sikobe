<?php

namespace App\Http\Controllers\Admin;

/*
 * Author: Ikbal Mohamad Hikmat <hikmat.iqbal@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePosko;
use App\Posko as Model;
use App\Modules\Area\Models\Eloquent\Area;
use App\Services\Territory as TerritoryService;
use App\Support\Asset;

class Posko extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Model::all();
        return view('admin.posko.index',[
          'lists' => $lists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posko = new Model;
        // Get all available territories
        list($districts, $villages) = $this->getTerritories();
        // Get Area List
        $areas = Area::all();

        Asset::add('https://maps.googleapis.com/maps/api/js?key='.env('GOOGLE_API_KEY'), 'footer.specific.js');
        Asset::add('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-map/3.0-rc1/min/jquery.ui.map.full.min.js', 'footer.specific.js');
        Asset::add(elixir('assets/js/map-picker.js'), 'footer.specific.js');

        return view('admin.posko.main-form',[
          'data' => $posko,
          'villages'  => $villages,
          'areas' => $areas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePosko $request)
    {
        $data = $request->all();
        if (Model::create($data)) {
          return redirect('/ctrl/posko')->with('success', 'Posko Berhasil Disimpan');
        }
        return redirect('/ctrl/posko')->with('error', 'Posko Gagal Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $posko = Model::find($id);
      // Get all available territories
      list($districts, $villages) = $this->getTerritories();
      // Get Area List
      $areas = Area::all();

      Asset::add('https://maps.googleapis.com/maps/api/js?key='.env('GOOGLE_API_KEY'), 'footer.specific.js');
      Asset::add('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-map/3.0-rc1/min/jquery.ui.map.full.min.js', 'footer.specific.js');
      Asset::add(elixir('assets/js/map-picker.js'), 'footer.specific.js');

      return view('admin.posko.main-form',[
        'data' => $posko,
        'villages'  => $villages,
        'areas' => $areas
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePosko $request, $id)
    {
      $data = $request->all();
      if (Model::find($id)->update($data)) {
        return redirect('/ctrl/posko')->with('success', 'Posko Berhasil Diperbaharui');
      }
      return redirect('/ctrl/posko')->with('error', 'Posko Gagal Diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if (Model::find($id)->delete()) {
        return back()->with('success', 'Berhasil Dihapus!');
      }
      return back()->with('error', 'Gagal Dihapus!');
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
