<?php

namespace Textline\Exceptions;

class ClientException extends \Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
