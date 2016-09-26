<?php

namespace App\Http\Controllers\Admin;

/*
 * Author: Sulaeman <me@sulaeman.com>.
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
use App\Presenter\User as UserPresenter;
use App\Services\User as UserService;

use RuntimeException;
use App\Modules\User\RecordNotFoundException;

class User extends Controller
{
    /**
     * Show the profile.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        Asset::add(elixir('assets/css/profile.css'), 'header.specific.css');

        return view('admin.profile');
    }

    /**
     * Update the profile.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request)
    {
        $service = $this->getService();

        try {
            $response = $service->updateProfile($this->user->id);

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
     * Show the items.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // You can implement this later
        if (Gate::denies('show', $this)) {
            abort(403);
        }

        $limit = 10;
        $page  = (int) $request->get('page', 1);

        $service = $this->getService();

        list($collection, $total) = $service->search([], $page, $limit);

        // Optional wrapping to a presenter, as User object is required by default
        $collection = $collection->map(function($item) {
            return new UserPresenter($item);
        });

        $list = new LengthAwarePaginator(
            $collection->all(),
            $total,
            $limit,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('admin.users', [
            'list' => $list
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
     * Return the service instance.
     *
     * @return \App\Services\User
     */
    private function getService()
    {
        $service = new UserService();

        return $service;
    }
}
