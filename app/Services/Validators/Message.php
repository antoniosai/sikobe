<?php

namespace App\Services\Validators;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;

class Message
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'sender'  => 'required|max:100',
        'phone'   => 'required|max:50',
        'email'   => 'email|max:50',
        'content' => 'required'
    ];

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Validate data.
     *
     * @param  array $fields
     *
     * @return boolean|\Illuminate\Validation\Validator
     */
    public function isValid(Array $fields)
    {
        $rules    = [];
        $messages = [];

        foreach ($this->validationRules as $key => $value) {
            if (isset($fields[$key])) {
                $rules[$fields[$key]] = $value;

                $messages[$fields[$key].'.required'] = 'Input ini harus di isi';
                $messages[$fields[$key].'.max']      = 'Max isi input ini adalah :max karakter';
                $messages[$fields[$key].'.email']    = 'Email tidak valid';
            }
        }

        // Do validation
        $validator = $this->getValidationFactory()->make(
            $this->request->all(),
            $rules, 
            $messages
        );

        if (! $validator->fails()) {
            return true;
        }

        return $validator;
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    private function getValidationFactory()
    {
        return app('validator');
    }
}
