<?php
class RedisCache extends Cache {
    private $redis = null;
    private $server = '127.0.0.1';
    private $port = 6379;
    private $timeout = 20;

    public function __construct($config = '') {
        $this->server = $config['host'];
        $this->port = $config['port'];
    }

    public function init() {
        $this->redis = new Redis();
        if (!$this->redis->pconnect($this->server, $this->port, $this->timeout)) {
            return false;
        }
        if (!$this->redis->auth(C('REDIS_PASS'))) {
            return false;
        }
        return true;
    }

    public function get($key) {
        return $this->redis->get($key);
    }

    public function set($key, $value, $cache_time = 0) {
        if ($cache_time <= 0) {
            return $this->redis->set($key, $value);
        }
        return $this->redis->setex($key, $cache_time, $value);
    }

    public function replace($key, $value) {
        return $this->redis->setnx($key, $value);
    }
    
    public function incr($key, $by = 1) {
        return $this->redis->incrBy($key, $by);
    }
}
