<?php

namespace App\Services;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Services\Service;
use App\Services\Validators\Message as MessageValidator;

use App\Modules\Message\Repository;

use RuntimeException;

class Message extends Service
{
    /**
     * Search black list items.
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
        $repository = $this->getMessageRepository();
        $collection = $repository->search($params, $page, $limit);

        return new LengthAwarePaginator(
            $collection->all(), 
            $repository->getTotal(), 
            $limit, 
            $page, 
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * Create new item.
     *
     * @param  array $fields
     *
     * @return \Illuminate\Validation\Validator|App\Modules\Message\Models\Message
     * @throws \RuntimeException
     */
    public function create(Array $fields)
    {
        // Validate request data
        $validator = $this->getValidator();

        if (true !== ($validation = $validator->isValid($fields))) {
            return $validation;
        }

        $request = $this->getRequest();

        $sender = (isset($fields['sender'])) ? $request->get($fields['sender']) : '';
        $content = (isset($fields['sender'])) ? $request->get($fields['content']) : '';
        $phone = (isset($fields['sender'])) ? $request->get($fields['phone']) : '';
        $email = (isset($fields['sender'])) ? $request->get($fields['email']) : '';

        return $this->getMessageRepository()->create([
            'title'   => 'Pesan dari '.trim($sender), 
            'content' => trim($content), 
            'sender'  => trim($sender), 
            'phone'   => trim($phone), 
            'email'   => trim($email)
        ]);
    }

    /**
     * Return validator instance.
     *
     * @return \App\Services\Validators\Message
     */
    private function getValidator()
    {
        return new MessageValidator($this->getRequest());
    }

    /**
     * Return Message instance.
     *
     * @return \App\Modules\Message\Repository
     */
    private function getMessageRepository()
    {
        return app(Repository::class);
    }
}
