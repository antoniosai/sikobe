<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller as BaseController;
use App\Support\Asset;

class Controller extends BaseController
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $scripts = 'var baseUrl = "'.url('/').'";';

        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == 'on') {
                Asset::$secure = true;
            }
        }
        
        Asset::addScript($scripts, 'footer.scripts');
    }
}
