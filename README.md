# Textline PHP

## Setup

Using composer:

```bash
composer require allcdnboy/textline
```

## Usage

### Authentication

When initializing the client you must provide your api key (obtained
[here](https://application.textline.com/organization/api_settings)) and email
and password of the agent you want represented by your API requests. This will
make a request to the Textline API to retrieve an authentication token which 
will then automatically be attached to all subsequent requests to the api. 
If you already know your token you may pass it in as the fourth argument.

```php
<?php
$apiKey = "ZZZZZZZZ"; // Your account api key
$email = "agent@acme.com"; // Email address of the agent
$password = "XXXXXX"; // Password associated with the email address above
$token = 'YYYYYYYY'; // Can be left null

$client = new Textline\Client($email, $password, $apiKey, $token);
```

If the api key and/or token are incorrect a `Textline\Exceptions\AuthenticationException` will be thrown.

### Conversations

#### List conversations

```php
$client->conversations()
       ->get();
```
To add query parameters listed [here](https://textline.docs.apiary.io/#reference/conversations/conversations/list-conversations) pass in an array of key values:

```php
$query = [
    'page' => 1,
    'page_size' => 20,
    'query' => 'foo',
];

$client->conversations()
       ->get($query);
```

#### Message a phone number

```php
$number = '0781234567';

use Textline\Resources\Message;

$message = new Message('foo');

// (optional) add attachment
$message->addAttachment('application/pdf','name-of-file.pdf', '/path/to/file');
                
$client->conversations()
       ->messageByPhone($number, $message);
```
For a list of a `$body` options see [here](https://textline.docs.apiary.io/#reference/conversations/phone-numbers/message-a-phone-number). Note that either `whisper` or `comment` must be specified in the request, but not both.

#### Schedule a message by phone number

```php
$number = '07812345678';
$timestamp = 1551528788; # unix timestamp
$body = 'foo';
$params = [
    'group_uuid' => '123' # optional extra params
];

$client->conversations()
       ->scheduleByPhone($number, $timestamp, $body, $params);
```

### Conversation

#### Retrieve a conversation

```php
$uuid = 'abc-123';

$client->conversation($uuid)
       ->retrieve();
```

To add query parameters listed [here](https://textline.docs.apiary.io/#reference/conversations/conversation/retrieve-a-conversation) pass in an array of key values as the second argument.

#### Message a conversation

Pass in the conversation uuid as the first argument and the message attributes as the second argument:

```php
$uuid = 'abc-123';
$body = [
    'comment' => [
        'body' => 'foo',
    ],
    'whisper' => [
        'body' => 'bar',
    ]
];

$client->conversation($uuid)
       ->message($body);
```

#### Schedule a message to a conversation

```php
$uuid = 'abc-123';
$timestamp = 1551528788; # unix timestamp
$body = 'foo';

$client->conversation($uuid)
       ->scheduleMessage($timestamp, $body);
```

#### Resolve a conversation

```php
$uuid = 'abd-123';

$client->conversation($uuid)
       ->resolve();
```

#### Transfer a conversation

```php
$uuid = 'abd-123';

$client->conversation($uuid)
       ->transfer();
```

### Customers

#### List customers

```php
$client->customers()
       ->get();
```
To add query parameters listed [here](https://textline.docs.apiary.io/#reference/customers/customers/list-customers) pass in an array of key values:

```php
$query = [
    'page' => 1,
    'page_size' => 20,
    'query' => 'foo',
];

$client->customers()
       ->get($query);
```

#### Create a customer

```php
$number = '07812345678';
$attrs = [
    'email' => 'john@mail.com',
    'name' => 'John Mail',
];

$client->customers()
       ->create($number, $attrs);
```

For a full list of attributes see [here](https://textline.docs.apiary.io/#reference/customers/customers/create-a-customer)

### Customer

#### Retrieve a customer

```php
$uuid = 'abc-123';

$client->customer($uuid)
       ->retrieve();
```

#### Update a customer

```php
$uuid = 'abc-123';
$attrs = [
    'name' => 'John Smith',
    'email' => 'john@smith.com',
];

$client->customer($uuid)
       ->update($attrs);
```

### Organization

#### Retrieve organization details

```php
$query = [
    'include_groups' => false,
];

$client->orgnization()
       ->get($query);
```

For a full list of available query options see [here](https://textline.docs.apiary.io/#reference/account/organization/organization-details)

## Exceptions

* If a conversation, customer or other resource identified with a `uuid` is not found, a `Textline\Exceptions\ResourceNotFoundException` will be thrown

* If the rate limit is exceeded a `Textline\Exceptions\RateLimitException` will be thrown

* For all other client errors, a generic `Textline\Exceptions\ClientException` will be thrown
