<?php

namespace App\Services\Validators;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;

use App\Services\Territory as TerritoryService;

use App\Modules\Territory\RecordNotFoundException;

class Area
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
        'title'       => 'required', 
        'description' => 'required', 
        'address'     => 'required', 
        'village'     => 'required|is_village_exist'
    ];

    /**
     * The status validation rules.
     *
     * @var array
     */
    protected $validationStatusRules = [
        'description' => 'required', 
        'scale'       => 'required'
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
     * @return boolean|\Illuminate\Validation\Validator
     */
    public function isValid()
    {
        // Validate that value is not available
        $service = $this->getTerritoryService();

        $this->getValidationFactory()->extend(
            'is_village_exist', function ($attribute, $value) use ($service) {
                try {
                    $service->getVillage($value);
                    return true;
                } catch (RecordNotFoundException $e) {
                    return false;
                }
            }
        );

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
     * Validate status data.
     * 
     * @return boolean|\Illuminate\Validation\Validator
     */
    public function isValidStatus()
    {
        // Do validation
        $validator = $this->getValidationFactory()->make(
            $this->request->all(), 
            $this->validationStatusRules
        );

        if (! $validator->fails()) {
            return true;
        }

        return $validator;
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
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    private function getValidationFactory()
    {
        return app('validator');
    }
}
