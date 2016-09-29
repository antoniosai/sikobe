<?php

namespace App\Http\Controllers\Front;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;

use App\Support\Asset;
use App\Services\Collection as CollectionService;

class Information extends Controller
{
    /**
     * Show the informations page
     *
     * @param  \Illuminate\Http\Request  $request.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $identifier = 'information';
        $limit      = 5;
        $page       = (int) $request->get('page', 1);
        $search     = $request->get('search', '');

        $result = $this->getCollectionService()->search([
            'identifier' => $identifier, 
            'search'     => $search
        ], $page, $limit);

        Asset::add(elixir('assets/css/informations.css'), 'header.top.specific.css');

        return view('informations', [
            'search' => $search, 
            'list'   => $result
        ]);
    }

    /**
     * Return the Collection service instance.
     *
     * @return \App\Services\Collection
     */
    private function getCollectionService()
    {
        $service = new CollectionService();

        return $service;
    }
}
