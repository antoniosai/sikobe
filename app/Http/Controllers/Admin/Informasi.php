<?php

namespace App\Http\Controllers;


/*
 * Author: Antonio Saiful Islam <finallyantonio@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


 use Gate;

 use Illuminate\Http\Request;
 use Illuminate\Validation\Validator;
 use Illuminate\Pagination\Paginator;
 use Illuminate\Pagination\LengthAwarePaginator;

 use App\Support\Asset;
 use App\Presenter\BootstrapThreePresenter;

 use App\Services\Collection as CollectionService;

 use RuntimeException;

class Informasi extends Controller
{
    /**
     * Display a listing of the resource.
     * Code Owner : Antonio Saiful Islam
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = Collection::all();

      return view('admin.informasi', [
        '$data' => $data
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
      $service = $this->getService();

      try {
          $response = $service->create($request->all());

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $service = $this->getService();

      try {
          $response = $service->informasiUpdate($this->user->id);

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
    public function destroy($id)
    {
        $service = $this->getService();

        $response = $service->delete($id);

        $request->session()->flash('success', 'Informasi berhasil dihapus!');

        return back();
    }

    private function getService()
    {
        $service = new CollectionService();

        return $service;
    }
}
