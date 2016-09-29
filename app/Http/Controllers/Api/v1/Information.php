<?php

namespace App\Http\Controllers\Api\v1;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;

use Dingo\Api\Routing\Helpers;

use App\Services\Collection as CollectionService;

use App\Presenter\Api\Collection as CollectionPresenter;

class Information extends Controller
{
    use Helpers;

    /**
     * Return the all information.
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $identifier = 'information';
        $limit      = (int) $request->get('limit', 10);
        $page       = (int) $request->get('page', 1);

        $result = $this->getService()->search([
            'identifier' => $identifier
        ], $page, $limit);
        
        return $this->response->paginator(
            $result, 
            new CollectionPresenter
        );
    }

    /**
     * Return the service instance.
     *
     * @return \App\Services\Area
     */
    private function getService()
    {
        return new CollectionService();
    }
}
