<?php

namespace App\Http\Controllers\Front;

use App\Support\Asset;

class Home extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Asset::add(elixir('assets/css/home.css'), 'header.top.specific.css');
        Asset::add(elixir('assets/js/home.js'), 'footer.specific.js');
        Asset::add('home/build/public/assets/main'.env('HOME_APP_MAIN_VERSION').'.js', 'footer.specific.js');
        Asset::add('home/build/public/assets/intl.1'.env('HOME_APP_INTL_VERSION').'.js', 'footer.specific.js');

        $locale = 'en';

        // Parse default messages
        $params = [
            'runtime' => [
                'initialNow'       => time(), 
                'availableLocales' => ['en'],
                'baseUrl'          => url('/')
            ], 
            'intl' => [
                'initialNow' => time(), 
                'locale'     => $locale, 
                'newLocale'  => null, 
                'messages'   => [
                    $locale => [
                        'dummy' => 'dumb'
                    ]
                ]
            ]
        ];

        $params = json_encode($params);
        
        return view('home', [
            'params' => $params
        ]);
    }
}
