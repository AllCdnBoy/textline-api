<?php

namespace Textline\Resources;

class Conversations extends Resource
{
    public function get(array $query = [])
    {
        return $this->client
            ->get('api/conversations.json', $query)
            ->getContent();
    }

    public function getPreview(array $query = [])
    {
        return $this->client
            ->get('conversations.json', $query)
            ->getContent();
    }

    public function messageByPhone(string $number, $body = [])
    {
        return $this->client
            ->post('api/conversations.json', array_merge([
                'phone_number' => $number
            ], $body))
            ->getContent();
    }

    public function scheduleByPhone(string $number, int $timestamp, string $comment, array $body = [])
    {
        return $this->client
            ->post("api/conversations/schedule.json", array_merge([
                'phone_number' => $number,
                'timestamp' => $timestamp,
                'comment' => [
                    'body' => $comment
                ]
            ], $body))
            ->getContent();
    }
}
