<?php

namespace App\Http\Controllers\Front;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Support\Asset;

use App\Services\Territory as TerritoryService;
use App\Services\Area as AreaService;

class Home extends Controller
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
        Asset::add('https://maps.googleapis.com/maps/api/js?key='.env('GOOGLE_API_KEY'), 'footer.specific.js');

        $model = $this->getAreaService()->getEmptyModel();

        list($villages) = $this->getTerritoryService()->searchVillages([
            'area_table'  => $model->getTable(), 
            'province_id' => $this->provinceId, 
            'regency_id'  => $this->regencyId, 
            'order_by'    => 'name'
        ], 1, 0);

        $locale = 'en';

        // Parse default messages
        $params = [
            'runtime' => [
                'initialNow'       => time(), 
                'availableLocales' => ['en'], 
                'baseUrl'          => url('/'), 
                'territory'        => [
                    'villages' => $villages->all()
                ]
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

    /**
     * Return the area service instance.
     *
     * @return \App\Services\Area
     */
    private function getAreaService()
    {
        $service = new AreaService();

        return $service;
    }
}
