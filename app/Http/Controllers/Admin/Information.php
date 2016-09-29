<?php

namespace App\Http\Controllers\Admin;
/*
 * Author: Antonio Saiful Islam <finallyantonio@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<< HEAD
 use Illuminate\Http\Request;
 use Illuminate\Validation\Validator;
=======

 use Illuminate\Http\Request;
 use Illuminate\Validation\Validator;

>>>>>>> 731c81bb67fce7ab0d30ad3ca5e200df7cf4be8c
 use App\Services\Collection as CollectionService;
 use RuntimeException;

 use App\Modules\Collection\Models\Eloquent\Collection as Model;

class Information extends Controller
{
    /**
     * Display a listing of the resource.
     * Code Owner : Antonio Saiful Islam
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $limit = 10;
      $page  = (int) $request->get('page', 1);
      $service = $this->getService();
<<<<<<< HEAD
      $result = $service->search([], $page, $limit);
=======

      $result = $service->search([], $page, $limit);

>>>>>>> 731c81bb67fce7ab0d30ad3ca5e200df7cf4be8c
      return view('admin.information.list', [
          'list' => $result
      ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      $data['author_id'] = $this->user->id;
      $information = Model::create($data);
      if ($information) {
        return redirect('/ctrl/information')->with('success', 'Informasi Berhasil Ditambahkan');
      }
      return redirect('/ctrl/information')->with('error', 'Informasi Gagal Ditambahkan');
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
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function form(Request $request, $id = 0)
    {
        $service = $this->getService();
        try {
            $data = $service;
        } catch (RecordNotFoundException $e) {
            if ($id > 0) {
                abort(404);
            } else {
                $data = $service->getEmptyModel();
            }
        } catch (RuntimeException $e) {
            abort(500);
        }
        return view('admin.information.form', [
            // 'data'      => new AreaPresenter($data)
            'data'  => $data
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $data = $request->all();
      $information = Model::find($request->input('id'));
      if ($information->update($data)) {
        return redirect('/ctrl/information')->with('success', 'Informasi Berhasil Diperbaharui');
      }
      return redirect('/ctrl/information')->with('error', 'Informasi Gagal Diperbaharui');
    }
    /**
     * Search the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      $service = $this->getService();
      $response = $service->search($request->all());
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
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
            return back();
        }
        $request->session()->flash('success', 'Berhasil dihapus!');
        return redirect('/ctrl/information');
    }
    private function getService()
    {
        $service = new CollectionService();
        return $service;
    }
}
