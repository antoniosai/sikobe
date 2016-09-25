<?php

namespace App\Services\Validators;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;

class Collection
{

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'author_id'   => 'required', 
        'title'       => 'required', 
        'description' => 'required'
    ];

    /**
     * Validate data.
     * 
     * @return boolean|\Illuminate\Validation\Validator
     */
    public function isValid()
    {
        // Do validation
        $validator = $this->getValidationFactory()->make(
            $this->request->all(), 
            $this->validationRules
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
