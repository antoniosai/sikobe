<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller as BaseController;
use App\Support\Asset;

class Controller extends BaseController
{
    /**
     * The User instance.
     *
     * @var \App\Modules\User\Models\User
     */
    protected $user;

    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if (isset($_SERVER['HTTPS'])) {
                if ($_SERVER['HTTPS'] == 'on') {
                    Asset::$secure = true;
                }
            }

            view()->share('user', $this->user->getPresenter());

            return $next($request);
        });
    }
}
