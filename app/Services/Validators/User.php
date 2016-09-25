<?php

namespace App\Services\Validators;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

use App\Modules\User\Repository;

use App\Modules\User\RecordNotFoundException;

class User
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
        'email'     => 'required|email|value_unique', 
        'name'      => 'required', 
        'phone'     => 'required', 
        'activated' => 'required', 
        'is_admin'  => 'required'
    ];

    /**
     * The profile validation rules.
     *
     * @var array
     */
    protected $profileValidationRules = [
        'email' => 'required|email|value_unique', 
        'name'  => 'required', 
        'phone' => 'required'
    ];

    /**
     * The user password validation rules.
     *
     * @var array
     */
    protected $passwordValidationRules = [
        'current_password' => 'required|min:6|current_paswd', 
        'password'         => 'required|confirmed|min:6'
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
     * @param  integer  $userId
     * 
     * @return boolean|\Illuminate\Validation\Validator
     */
    public function isValid($userId = 0)
    {
        $repository = $this->getUserRepository();

        // Validate that value is not available
        $this->getValidationFactory()->extend(
            'value_unique', function ($attribute, $value) use ($repository, $userId) {
                try {
                    $user = $repository->findBy([
                        'email' => $value
                    ]);

                    if ( ! empty($userId)) {
                        return $user->id == $userId;
                    }

                    return false;
                } catch (RecordNotFoundException $e) {
                    return true;
                }
            }
        );

        $validationRules = $this->validationRules;

        $isPasswordRequired = false;
        if (empty($userId)) {
            $isPasswordRequired = true;
        } else {
            $password = $this->request->get('password');
            if ( ! empty($password)) {
                $isPasswordRequired = true;
            }
        }

        if ($isPasswordRequired) {
            $validationRules['password'] = 'required|confirmed|min:6';
        }

        // Do validation
        $validator = $this->getValidationFactory()->make(
            $this->request->all(), 
            $validationRules
        );

        if (! $validator->fails()) {
            return true;
        }

        return $validator;
    }

    /**
     * Validate profile data.
     *
     * @param  integer  $userId
     * 
     * @return boolean|\Illuminate\Validation\Validator
     */
    public function isValidProfile($userId)
    {
        $repository = $this->getUserRepository();

        // Validate that value is not available
        $this->getValidationFactory()->extend(
            'value_unique', function ($attribute, $value) use ($repository, $userId) {
                try {
                    $user = $repository->findBy([
                        'email' => $value
                    ]);

                    if ( ! empty($userId)) {
                        return $user->id == $userId;
                    }

                    return false;
                } catch (RecordNotFoundException $e) {
                    return true;
                }
            }
        );

        // Do validation
        $validator = $this->getValidationFactory()->make(
            $this->request->all(), 
            $this->profileValidationRules
        );

        if (! $validator->fails()) {
            return true;
        }

        return $validator;
    }

    /**
     * Validate password data.
     *
     * @param  string  $email
     * 
     * @return boolean|\Illuminate\Validation\Validator
     */
    public function isValidPassword($email)
    {
        $guard = $this->getGuard();
        
        // Validate that current password is match
        $this->getValidationFactory()->extend(
            'current_paswd', 
            function($attribute, $value) use ($guard, $email) {
                return $guard->validate([
                    'email'    => $email, 
                    'password' => $value
                ]);
            }
        );

        // Do validation
        $validator = $this->getValidationFactory()->make(
            $this->request->all(), 
            $this->passwordValidationRules
        );

        if (! $validator->fails()) {
            return true;
        }

        return $validator;
    }

    /**
     * Return User Repository instance.
     *
     * @return \App\Modules\User\Repository
     */
    private function getUserRepository()
    {
        return app(Repository::class);
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

    /**
     * Get a guard instance.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    private function getGuard()
    {
        return app(Guard::class);
    }
}
