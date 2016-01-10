<?php

namespace DC\Cache\Implementations\Memcached;

class MemcacheConfiguration {
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;

    function __construct($host, $port = null) {

        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }
} 