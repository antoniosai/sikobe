<?php

namespace App\Http\Controllers\Admin;

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

      list($collection, $total) = $service->search([], $page, $limit);

      $list = new LengthAwarePaginator(
          $collection->all(),
          $total,
          $limit,
          $page,
          ['path' => Paginator::resolveCurrentPath()]
      );

      return view('admin.information.list', [
          'list' => $list
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

      $data = [
        'author_id' => $this->user->id,
        'identifier' => 'information',
        'title' => $request->input('title'),
        'description' => $request->input('description')
      ];

      try {
          $response = $service->create($data);

          if ($response instanceOf Validator) {
              $request->session()->flash('error', 'Tossslong perbaiki input dengan tanda merah!');

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
