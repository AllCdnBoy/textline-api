<?php

namespace Textline\Resources;

class Customers extends Resource
{
    public function get(array $query = [])
    {
        return $this->client
                         ->get('api/customers.json', $query)
                         ->getContent();
    }

    public function create(string $number, $body = [])
    {
        return $this->client
                         ->post('api/customers.json', ['customer' => array_merge($body, [
                             'phone_number' => $number
                         ])])
                         ->getContent();
    }
}
