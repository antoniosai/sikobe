<?php

namespace App\Http\Controllers\Admin;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;

use App\Services\Message as MessageService;

class Message extends Controller
{
    /**
     * Show the items.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit  = 10;
        $page   = (int) $request->get('page', 1);
        $search = trim($request->get('search'));

        $service = $this->getMessageService();

        $list = $service->search([
            'search' => $search
        ], $page, $limit);

        return view('admin.message.list', [
            'filter' => [
                'search' => $search
            ],
            'list'   => $list
        ]);
    }

    /**
     * Return the message service instance.
     *
     * @return \App\Services\Message
     */
    private function getMessageService()
    {
        $service = new MessageService();
        $service->setUser($this->user);

        return $service;
    }
}
