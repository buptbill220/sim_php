<?php
class MemcacheCache extends Cache {
    private $mem = null;
    private $server = '';
    private $port = 11211;
    
    public function __construct($config = '') {
        $this->server = $config['host'];
        $this->port = $config['port'];
    }

    public function init() {
        $this->mem = new Memcached('this->memd_pool');
        $ss = $this->mem->getServerList();
        if (empty($ss) || $ss[0]['host'] === '') {
            $this->mem->setOption(Memcached::OPT_RECV_TIMEOUT, 1000);
            $this->mem->setOption(Memcached::OPT_SEND_TIMEOUT, 1000);
            $this->mem->setOption(Memcached::OPT_TCP_NODELAY, true);
            $this->mem->setOption(Memcached::OPT_SERVER_FAILURE_LIMIT, 50);
            $this->mem->setOption(Memcached::OPT_CONNECT_TIMEOUT, 500);
            $this->mem->setOption(Memcached::OPT_RETRY_TIMEOUT, 300);
            $this->mem->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
            $this->mem->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
            // 如果是集群，可以添加多个server
            $this->mem->addServer($this->server, $this->port);
        }
    }

    public function get($key) {
        return $this->mem->get($key);
    }

    public function set($key, $value, $cache_time = 86400) {
        return $this->mem->set($key, $value, $cache_time);
    }

    public function replace($key, $value) {
        return $this->mem->replace($key, $value);
    }

    public function incr($key, $by = 1) {
        return $this->mem->increment($key, $by);
    }

    function __destruct() {
        //if client memcached version >= 2.0, then call quit
        //$this->mem->quit();
    }
}
