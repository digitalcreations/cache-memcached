![DC\Cache - Caching interface](logo.png)

## Installation

```
$ composer install dc/cache-memcache
```

Or add it to `composer.json`:

```json
"require": {
	"dc/cache-memcache": "0.*",
}
```

```
$ composer install
```

## Getting started

You'll need to provide a `\DC\Cache\Implementations\Memcache\MemcacheConfiguration` object when constructing, that will give us the connection options for your memcache session:

```php
$cache = new \DC\Cache\Implementations\Memcache\Cache(
  \DC\Cache\Implementations\Memcache\MemcacheConfiguration('localhost', '2209'));
```

Otherwise, use it according [to the interface](http://github.com/digitalcreations/cache).