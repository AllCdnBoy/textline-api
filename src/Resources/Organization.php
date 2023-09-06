<?php

namespace Textline\Resources;

class Organization extends Resource
{
    public function get(array $query = [])
    {
        $response = $this->client
                         ->get("api/organization.json", $query)
                         ->getContent();

        return $response;
    }
}
