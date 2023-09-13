<?php

namespace Textline\Resources;

class Message
{
    protected $messageBody;
    protected $attachments = [];

    public function __construct($message, $type = 'normal')
    {
        $this->addMessage($message, $type);
    }

    public function addAttachment($contentType, $name, $url, $isImage = '')
    {
        $this->attachments[] = [
            'content_type' => $contentType,
            'name' => $name,
            'url' => $url,
            'is_image' => $isImage
        ];
    }

    public function addMessage($message, $type = 'normal')
    {
        if ($type == 'whisper') {
            $this->messageBody = ['whisper' => $message];
        } else {
            $this->messageBody = ['body' => $message];
        }
    }

    public function getBody()
    {
        $body = ['comment' => $this->messageBody];

        if ($this->attachments) {
            $body['attachments'] = $this->attachments;
        }

        return $body;

    }
}
