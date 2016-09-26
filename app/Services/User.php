<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Validation\Validator;

use App\Services\Validators\User as UserValidator;

use App\Modules\User\Repository;
use App\Modules\User\Models\User as UserContract;

use RuntimeException;

class User extends Service
{
    /**
     * Update the profile.
     *
     * @param  Integer $id
     *
     * @return \Illuminate\Validation\Validator|mixed
     * @throws \RuntimeException
     */
    public function updateProfile($id)
    {
        // Validate request data
        $validator = $this->getValidator();

        $request = $this->getRequest();

        $userRepository = $this->getUserRepository();

        $item = $userRepository->findBy(['id' => $id]);

        $updatePassword = (bool) $request->get('update_password', 0);

        if ($updatePassword) {
            if (true !== ($validation = $validator->isValidPassword($item->email))) {
                return $validation;
            }
        } else {
            if (true !== ($validation = $validator->isValidProfile($item->id))) {
                return $validation;
            }
        }

        if ($updatePassword) {
            // Populate data
            $data = [
                'password' => bcrypt($request->get('password'))
            ];
        } else {
            // Format user name data
            $name  = trim($request->get('name'));
            $names = explode(' ', $name);
            $firstName = $names[0];
            $lastName  = '';
            if (count($names) > 1) {
                $lastName = trim(str_replace($names[0], '', $name));
            }
            unset($names);

            // Populate data
            $data = [
                'email'      => $request->get('email'),
                'activated'  => (int) $request->get('activated', 0),
                'first_name' => $firstName,
                'last_name'  => $lastName
            ];

            // Update meta
            $userRepository->updateMeta($item->id, 'display_name', $name);
            $userRepository->updateMeta($item->id, 'phone', $request->get('phone'));
        }

        // Save
        $item->fill($data);

        if ( ! $item->save()) {
            throw new RuntimeException('Failed to update user');
        }

        return $item;
    }

    /**
     * Search list items.
     *
     * @param  array   $params
     * @param  integer $page
     * @param  integer $limit
     *
     * @return array
     * @throws \RuntimeException
     */
    public function search(Array $params = [], $page = 1, $limit = 10)
    {
        $repository = $this->getUserRepository();
        $collection = $repository->search($params, $page, $limit);

        return [$collection, $repository->getTotal()];
    }

    /**
     * Delete a item.
     *
     * @param  integer $id
     *
     * @return boolean
     * @throws \App\Modules\User\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function delete($id)
    {
        $item = $this->getUserRepository()->findBy([
            'id' => $id
        ]);

        return $item->delete();
    }

    /**
     * Create new item.
     *
     * @return \Illuminate\Validation\Validator|App\Modules\User\Models\User
     * @throws \RuntimeException
     */
    public function create()
    {
        // Validate request data
        $validator = $this->getValidator();

        if (true !== ($validation = $validator->isValid())) {
            return $validation;
        }

        $request = $this->getRequest();

        // Format user name data
        $name  = trim($request->get('name'));
        $names = explode(' ', $name);
        $firstName = $names[0];
        $lastName  = '';
        if (count($names) > 1) {
            $lastName = trim(str_replace($names[0], '', $name));
        }
        unset($names);

        // Create
        $data = [
            'email'      => $request->get('email'),
            'password'   => bcrypt($request->get('password')),
            'activated'  => (int) $request->get('activated', 0),
            'first_name' => $firstName,
            'last_name'  => $lastName
        ];

        $userRepository = $this->getUserRepository();

        $user = $userRepository->create($data);

        // Create meta
        $userRepository->updateMeta($user->id, 'display_name', $name);
        $userRepository->updateMeta($user->id, 'phone', $request->get('phone'));

        // Update group
        $groupAdmin   = $userRepository->findGroupBy(['name' => 'Administrators']);
        $groupRelawan = $userRepository->findGroupBy(['name' => 'Relawan']);

        if (is_object($groupAdmin) && is_object($groupRelawan)) {
            $isAdmin = (bool) $request->get('is_admin', 1);

            $userRepository->addToGroup($user->id, $groupRelawan->id);

            if ($isAdmin) {
                $userRepository->addToGroup($user->id, $groupAdmin->id);
            }
        }

        return $user;
    }

    /**
     * Save a item.
     *
     * @param  integer $id
     *
     * @return \Illuminate\Validation\Validator|mixed
     * @throws \RuntimeException
     */
    public function save($id)
    {
        // Validate request data
        $validator = $this->getValidator();

        $request = $this->getRequest();

        if (true !== ($validation = $validator->isValid($id))) {
            return $validation;
        }

        $userRepository = $this->getUserRepository();

        $item = $userRepository->findBy(['id' => $id]);

        // Format user name data
        $name  = trim($request->get('name'));
        $names = explode(' ', $name);
        $firstName = $names[0];
        $lastName  = '';
        if (count($names) > 1) {
            $lastName = trim(str_replace($names[0], '', $name));
        }
        unset($names);

        $password = $request->get('password');

        // Populate data
        $data = [
            'email'      => $request->get('email'),
            'activated'  => (int) $request->get('activated', 0),
            'first_name' => $firstName,
            'last_name'  => $lastName
        ];

        if ( ! empty($password)) {
            $data['password'] = bcrypt($password);
        }

        // Save
        $item->fill($data);

        if ( ! $item->save()) {
            throw new RuntimeException('Failed to update user');
        }

        // Update meta
        $userRepository->updateMeta($id, 'display_name', $name);
        $userRepository->updateMeta($id, 'phone', $request->get('phone'));

        // Update group
        $groupAdmin = $userRepository->findGroupBy(['name' => 'Administrators']);

        if (is_object($groupAdmin)) {
            $isAdmin = (bool) $request->get('is_admin', 1);

            if ($item->isInGroup('Administrators')) {
                if ( ! $isAdmin) {
                    $userRepository->removeFromGroup($item->id, $groupAdmin->id);
                }
            } else {
                if ($isAdmin) {
                    $userRepository->addToGroup($item->id, $groupAdmin->id);
                }
            }
        }

        return $item;
    }

    /**
     * Return validator instance.
     *
     * @return \App\Services\Validators\Preferences\User
     */
    private function getValidator()
    {
        return new UserValidator($this->getRequest());
    }

    /**
     * Return User instance.
     *
     * @return \App\Modules\User\Repository
     */
    private function getUserRepository()
    {
        return app(Repository::class);
    }
}
