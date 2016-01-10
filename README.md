![DC\Cache - Caching interface](logo.png)

## Installation

```
$ composer install dc/cache-memcached
```

Or add it to `composer.json`:

```json
"require": {
	"dc/cache-memcached": "0.*",
}
```

```
$ composer install
```

## Getting started

You'll need to provide a `\DC\Cache\Implementations\Memcache\MemcacheConfiguration` object when constructing, that will give us the connection options for your memcached session:

```php
$cache = new \DC\Cache\Implementations\Memcached\Cache(
  \DC\Cache\Implementations\Memcached\MemcacheConfiguration('localhost', '2209'));
```

Otherwise, use it according [to the interface](http://github.com/digitalcreations/cache).