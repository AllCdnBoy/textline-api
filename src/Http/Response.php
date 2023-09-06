<?php

namespace Textline\Http;

class Response
{
    /**
     * @var mixed
     */
    protected $statusCode;

    /**
     * @var mixed
     */
    protected $content;

    /**
     * @var array
     */
    protected $headers;

    public function __construct($statusCode, $content, $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->headers = $headers;
    }

    /**
     * Getter for statusCode
     *
     * @return string
     * @author Dom Batten <db@mettrr.com>
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Getter for content
     *
     * @return string
     * @author Dom Batten <db@mettrr.com>
     */
    public function getContent($array = false)
    {
        $content = json_decode($this->content, $array);

        if (json_last_error() != JSON_ERROR_NONE) {
            return $this->getRawContent();
        }

        return $content;
    }

    /**
     * Getter for rawContent
     *
     * @return string
     */
    public function getRawContent()
    {
        return $this->content;
    }

    /**
     * Getter for headers
     *
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Return whether the response was successful
     *
     * @return bool
     * @author Dom Batten <db@mettrr.com>
     */
    public function successful()
    {
        return $this->statusCode < 400;
    }
}
