<?php

namespace DC\Cache\Implementations\Memcache;

class Cache implements \DC\Cache\ICache {

    /**
     * @var \Memcache
     */
    private $memcache;
    private $isConnected = false;
    /**
     * @var MemcacheConfiguration
     */
    private $configuration;

    function __construct(MemcacheConfiguration $configuration) {
        $this->memcache = new \Memcache;
        $this->configuration = $configuration;
    }

    /**
     * Only connect at the last possible moment. This enables you to get the cache provider, but not connect
     * until you have business with the cache.
     */
    private function connect() {
        if ($this->isConnected) return;
        $this->memcache->connect($this->configuration->getHost(), $this->configuration->getPort());
    }

    /**
     * Retrieve an item from cache
     *
     * @param string $key The key to store it under
     * @return mixed
     */
    function get($key)
    {
        $this->connect();
        return $this->memcache->get($key);
    }

    /**
     * Set an item in the cache
     *
     * @param string $key
     * @param mixed $value
     * @param int|\DateInterval|\DateTime $validity Number of seconds this is valid for (if int)
     * @return void
     */
    function set($key, $value, $validity = null)
    {
        $this->connect();
        $expires = 0;
        if ($validity instanceof \DateInterval) {
            $expires = date_create('@0')->add($validity)->getTimestamp();
        } else if ($validity instanceof \DateTime) {
            $expires = $validity->getTimestamp() - time();
        } else if (is_numeric($validity)) {
            $expires = (int)$validity;
        }

        $this->memcache->add($key, $value, null, $expires);
    }

    /**
     * Try to get an item, and if missed call the fallback method to produce the value and store it.
     *
     * @param string $key
     * @param callable $fallback
     * @param int|\DateInterval|\DateTime $validity Number of seconds this is valid for (if int)
     * @return mixed
     */
    function getWithFallback($key, callable $fallback, $validity = null)
    {
        $value = $this->get($key);
        // TODO: find a better way to prevent false negatives (boolean false as the stored value), e.g. by manually
        // serializing everything that goes in, and having get() throw if the content is not serialized
        if ($value === false) {
            $value = $fallback();
            $this->set($key, $value, $validity);
        }
        return $value;
    }

    /**
     * Remove a key from the cache.
     *
     * @param string $key
     * @return void
     */
    function delete($key)
    {
        $this->connect();
        $this->memcache->delete($key);
    }

    /**
     * Remove all items from the cache (flush it).
     *
     * @return void
     */
    function deleteAll()
    {
        $this->connect();
        $this->memcache->flush();
    }
}