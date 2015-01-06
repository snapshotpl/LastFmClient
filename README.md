LastFmClient
============

Modern Last.fm API client for php

[Last.fm API documentation](http://www.last.fm/api)

## Usage

You can call API methods using existing services:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$auth = new LastFmClient\Auth();
$auth->setApiKey('your-api-key');
$auth->setSecret('your-secret');
$auth->setToken('user-token');
$auth->setSession('user-session');

$transport = new LastFmClient\Transport\Curl();

$client = new LastFmClient\Client($auth, $transport);

$trackService = new LastFmClient\Service\Track();
$trackService->setClient($client);

$response = $trackService->getInfo('Numb', 'Linkin Park');

var_dump($response->getData());
```

If you want to call custom method use `LastFmClient\Client`:

```php
$client->call('resource.getAwesomeness', [], LastFmClient\Transport\TransportInterface::METHOD_GET);
```

### How to scrobble?

It's very simple! Prepare `LastFmClient\Auth` object with api key, secret, token and session key. Then just call method from `LastFmClient\Service\Track`:

```php
$trackService->scrobble('Seven Lions', 'Days to Come', $timestamp);
```

`$timestamp` is optional and can be integer with timestamp time or DateTime object.

You can scrobble multiple tracks in one request:

```php
$trackService->scrobbleBatch([
    [
        'artist' => 'Linkin Park',
        'track' => 'Numb',
        'timestamp' => time()-1000,
    ],
    [
        'artist' => 'Seven Lions',
        'track' => 'Days to Come',
        'timestamp' => time()-1200,
    ],
]);
```

### How to get `Token` and `Session`

You need to redirect user to auth page in Last.Fm:

```php
$url = $client->getAuthUrl();
header('Location: '.$url);
```

In callback url you will receive query string parameter `token`.

```php
$authService = LastFmClient\Service\Auth();
$authService->setClient($client);
$data = $authService->getSession()->getData();
var_dump($data);
```

More information:
* http://www.lastfm.pl/api/webauth
* http://www.lastfm.pl/api/authspec

### Transport

To make calls in API we provide simple CURL transport. We have in plan implements others transports like:
* Guzzle
* Httpfull
* Zend\Http

To use own transport just implement `LastFmClient\Transport\TransportInterface`

## Installation

Add to composer.json:
```json
{
    "require": {
        "snapshotpl/LastFmClient": "dev-master"
    }
}
```
