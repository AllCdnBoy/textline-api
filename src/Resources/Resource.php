<?php

namespace Textline\Resources;

use Textline\Http\Client as HttpClient;

abstract class Resource
{
    public function __construct(protected HttpClient $client) {}
}
