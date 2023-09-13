<?php

namespace Textline\Http;

class Response
{

    public function __construct(protected $statusCode, protected string $content, protected mixed $headers = []) {}

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function getContent($array = false): mixed
    {
        $content = json_decode($this->content, $array);

        if (json_last_error() != JSON_ERROR_NONE) {
            return $this->getRawContent();
        }

        return $content;
    }

    public function getRawContent()
    {
        return $this->content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function successful(): bool
    {
        return $this->statusCode < 400;
    }

    public function getErrors(): string
    {
        $content = json_decode($this->content);
        if (isset($content->errors)) {
            $buff = '';
            foreach ($content->errors as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $val2) {
                        $buff .= $key . ': ' . $val2;
                    }
                } else {
                    $buff .= $key . ': ' . $val;
                }
            }
            return $buff;
        }

        return $content->message;
    }
}
