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

use App\Services\CommandPost as CommandPostService;
use App\Services\File as FileService;

use App\Presenter\Api\CommandPost as CommandPostPresenter;
use App\Presenter\Api\File as FilePresenter;

use RuntimeException;
use App\Modules\CommandPost\RecordNotFoundException;

class CommandPost extends Controller
{
    use Helpers;

    /**
     * Return areas.
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $limit    = (int) $request->get('limit', 10);
        $page     = (int) $request->get('page', 1);
        $district = trim($request->get('district', ''));
        $village  = trim($request->get('village', ''));
        $area     = (int) $request->get('area');
        $include  = trim($request->get('include', ''));

        if ($district == 'all') {
            $district = '';
        }

        if ($village == 'all') {
            $village = '';
        }

        $result = $this->getService()->search([
            'district_id' => $district, 
            'village_id'  => $village, 
            'area_id'     => $area
        ], $page, $limit);
        
        return $this->response->paginator(
            $result, 
            new CommandPostPresenter, 
            [
                'include' => $include
            ]
        );
    }

    /**
     * Return area photos.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getPhotos($id)
    {
        $result = $this->getService()->getPhotos($id);
        
        return $this->response->collection(
            $result, 
            new FilePresenter
        );
    }

    /**
     * Return the service instance.
     *
     * @return \App\Services\CommandPost
     */
    private function getService()
    {
        return new CommandPostService();
    }

    /**
     * Return the file service instance.
     *
     * @return \App\Services\File
     */
    private function getFileService()
    {
        $service = new FileService();

        return $service;
    }
}
