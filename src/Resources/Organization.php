<?php

namespace Textline\Resources;

class Organization extends Resource
{
    public function get(array $query = [])
    {
        return $this->client
            ->get("api/organization.json", $query)
            ->getContent();
    }
}
