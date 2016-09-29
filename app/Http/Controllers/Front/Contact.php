<?php

namespace App\Http\Controllers\Front;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

use App\Support\Asset;

use App\Services\Message as MessageService;

use RuntimeException;

class Contact extends Controller
{
    /**
     * Show the contact page
     *
     * @param  \Illuminate\Http\Request  $request.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( ! $request->session()->exists('contact')) {
            $fields = ['sender', 'phone', 'email', 'content'];

            $hashedFields = [];

            foreach ($fields as $item) {
                $hashedFields[$item] = encrypt($item.time());
                $hashedFields[$item] = str_replace('.', '_', $hashedFields[$item]);
                $hashedFields[$item] = str_replace('/', '_', $hashedFields[$item]);
            }

            $request->session()->put('contact', $hashedFields);
        } else {
            $hashedFields = $request->session()->get('contact');
        }

        Asset::add(elixir('assets/css/contact.css'), 'header.top.specific.css');
        Asset::add(elixir('assets/js/contact.js'), 'footer.specific.js');
        Asset::add('https://maps.googleapis.com/maps/api/js?key='.env('GOOGLE_API_KEY').'&callback=initializeMap', 'footer.specific.js');

        $scripts = 'var latContact = '.env('POSKO_PUSAT_LATITUDE', 0).';';
        $scripts .= 'var lngContact = '.env('POSKO_PUSAT_LONGITUDE', 0).';';
        
        Asset::addScript($scripts, 'footer.scripts');

        return view('contact', [
            'fields' => $hashedFields
        ]);
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
        $hashedFields = $request->session()->get('contact');

        $service = $this->getMessageService();

        try {
            $response = $service->create($hashedFields);

            if ($response instanceOf Validator) {
                $request->session()->flash('error', 'Tolong perbaiki input dengan tanda merah!');

                $this->throwValidationException(
                    $request, $response
                );
            }
        } catch (RuntimeException $e) {
            abort(500);
        }

        $request->session()->flash('success', 'Pesan telah kami terima!');

        return back();
    }

    /**
     * Return the Message service instance.
     *
     * @return \App\Services\Message
     */
    private function getMessageService()
    {
        return new MessageService();
    }
}
