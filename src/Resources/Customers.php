<?php

namespace Textline\Resources;

use Textline\Http\Response;

class Customers extends Resource
{
    public function get(array $query = [])
    {
        return $this->client
            ->get('api/customers.json', $query)
            ->getContent();
    }

    public function create(string $number, $body = []): Response
    {
        return $this->client
            ->post('api/customers.json', ['customer' => array_merge($body, [
                'phone_number' => $number
            ])]);
    }
}
