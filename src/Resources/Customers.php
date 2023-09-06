<?php

namespace Textline\Resources;

class Customers extends Resource
{
    public function get(array $query = [])
    {
        $response = $this->client
                         ->get('api/customers.json', $query)
                         ->getContent();

        return $response;
    }

    public function create(string $number, $body = [])
    {
        $response = $this->client
                         ->post('api/customers.json', array_merge($body, [
                             'phone_number' => $number
                         ]))
                         ->getContent();

        return $response;
    }
}
