# Phraseanet API PHP-SDK

[![Build Status](https://secure.travis-ci.org/alchemy-fr/Phraseanet-PHP-SDK.png?branch=master)](http://travis-ci.org/alchemy-fr/Phraseanet-PHP-SDK)

The Phraseanet PHP SDK is an OO library to interact with
[Phraseanet API](https://docs.phraseanet.com/Devel).

#Documentation

Read the documentation at http://phraseanet-php-sdk.readthedocs.org/

## Basic Usage

### Create the client

Here is the minimum to create the Phraseanet client ; please
note that client `client-id`, `url`, `secret` and `token` a required. Please refer to
the [online documentation](https://docs.phraseanet.com/3.7/en/Devel/ApplicationDeveloper.html)
to get more more information about getting those.

```php
use PhraseanetSDK\Client;

$client = Client::create(array(
    'client-id' => '409ee2762ff49ce936b2ca6e5413607a',
    'secret'    => 'f53ea9b0da92e45f9bbba67439654ac3',
    'token'     => 'd855d9f66774eda3b67101055b03c1d6',
    'url'       => 'https://your.phraseanet-install.com/', // Phraseanet install URI
));
```

### Use the EntityManager

The `EntityManager` is the entry point to retrieve Phraseanet entities.

```php
$em = $client->getEntityManager();

$query = $em->getRepository('Record')->search(array(
    'query'        => 'animals',
    'offset_start' => 0,
    'per_page'     => 20,
    'bases'        => array(1, 4),
    'record_type'  => 'image'
));

echo $query->getTotalResults() . " items found in " . $query->getQueryTime() . " seconds\n";

foreach($query->getResults() as $record) {
    echo "Sub definition " . $subdef->getName() . " has URL " . $subdef->getPermalink()->getUrl() . "\n";
}
```

## Advanced Usage

### Log

Request can be logged for monitor or debug purpose by setting a PSR Logger in
the configuration.

```php
$client = Client::create(array(
    'client-id' => '409ee2762ff49ce936b2ca6e5413607a',
    'secret'    => 'f53ea9b0da92e45f9bbba67439654ac3',
    'token'     => 'd855d9f66774eda3b67101055b03c1d6',
    'url'       => 'https://your.phraseanet-install.com/',
    'logger'    => $logger,
));
```

### Cache

For performance, it is strongly recommended to use a cache system. This can be
easily done using the following configuration.

```php
$client = Client::create(array(
    'client-id' => '409ee2762ff49ce936b2ca6e5413607a',
    'secret'    => 'f53ea9b0da92e45f9bbba67439654ac3',
    'token'     => 'd855d9f66774eda3b67101055b03c1d6',
    'url'       => 'https://your.phraseanet-install.com/',
    'cache'  => array(
        'type'       => 'memcached', // cache type
        'host'       => '127.0.0.1', // cache server host
        'port'       => 11211,       // cache server port
        'lifetime'   => 300,         // cache lifetime in seconds
    ),
));
```

Cache parameters can be configured as follow :

 - type : either `array`, `memcache` or `memcached`.

## Silex Provider

A [Silex](http://silex.sensiolabs.org/) provider is bundled within this
package.

### Basic usage

```php
$app = new Silex\Application();
$app->register(new PhraseanetSDK\PhraseanetSDKServiceProvider(), array(
    'phraseanet-sdk.config' => array(
        'client-id' => $clientId,
        'secret'    => $secret,
        'url'       => $url,
        'token'     => $token,
    ),
));
```

### Configure cache and log

```php
$app = new Silex\Application();

$app->register(new PhraseanetSDK\PhraseanetSDKServiceProvider(), array(
    'phraseanet-sdk.config'           => array(
        'client-id' => $clientId,
        'secret' => $secret,
        'url' => $url,
        'token' => $token,
        'cache' => array(
            'type' => 'memcached',
            'type' => 'localhost',
            'type' => 11211,
            'type' => 300,
        ),
        'logger' => $logger,
    )
));
```

## Record / Play requests

### Recorder

Recorder can be enabled per requests through service provider using the
following code :

```php
$app = new Silex\Application();
$app->register(new PhraseanetSDK\PhraseanetSDKServiceProvider(), array(
    'phraseanet-sdk.config' => array(
        'client-id' => $clientId,
        'secret'    => $secret,
        'url'       => $url,
        'token'     => $token,
    ),
    'phraseanet-sdk.recorder.enabled' => true,
    'phraseanet-sdk.recorder.config' => array(
        'type' => 'memcached',
        'options' => array(
            'host' => 'localhost',
            'port' => 11211,
        ),
        'limit' => 5000 // record up to 5000 requests
    ),
));
```

Requests can be store either in `memcache`, `memcached` or `file`. To use file,
configuration should look like :

```php
$app = new Silex\Application();
$app->register(new PhraseanetSDK\PhraseanetSDKServiceProvider(), array(
    'phraseanet-sdk.recorder.config' => array(
        'type' => 'memcached',
        'options' => array(
            'file' => '/path/to/logfile.json',
        ),
        'limit' => 5000 // record up to 5000 requests
    ),
));
```

### Player

To replay stored requests, use the player

```php
$app['phraseanet-sdk.player']->play();
```

Please note that, in order to play request without using cache (to warm it for
example), you must use the `deny` cache revalidation strategy :

```php
$app->register(new PhraseanetSDK\PhraseanetSDKServiceProvider(), array(
    'phraseanet-sdk.config'           => array(
        'client-id' => $clientId,
        'secret' => $secret,
        'url' => $url,
        'token' => $token,
        'cache' => array(
            'type' => 'memcached',
            'type' => 'localhost',
            'type' => 11211,
            'type' => 300,
            'revalidate' => 'deny',  // important
        )
    )
));
```

## License

Phraseanet SDK is released under the MIT license.
