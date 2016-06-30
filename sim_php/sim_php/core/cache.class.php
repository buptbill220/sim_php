<?php
class Cache extends Base {
    const MAX_QUEUE_LEN = 50;

    protected $cacheType = null;
    protected $cacheQue = null;
    protected $cacheQueLen = 0;
    protected $handler = null;

    public function __construct() {
        $this->cacheQue = array();
        $this->cacheType = 'File';
        $this->cacheQueLen = Cache::MAX_QUEUE_LEN;
    }

    public static function getInstance($config = '') {
        $args = func_get_args();
        return get_instance_of(__CLASS__, 'factory', $args);
    }

    public function factory($config = '') {
        $config = $this->parseConfig($config);
        if (empty($config['type'])) {
            throw new Errorexp("no cache type set", $this);
        }
        $this->cacheType = $config['type'];
        $classname = $config['type'] . 'Cache';
        $this->handler = new $classname($config);
        return $this->handler;
    }

    public function init() {
        return $this->handler->init();
    }

    public function get($key) {
        return $this->handler->get($key);
    }

    public function set($key, $value, $cache_time = 86400) {
        return $this->handler->set($key, $value, $cache_time);
    }

	public function replace($key, $value) {
		return $this->handler->replace($key, $value);
	}

    public function incr($key, $by = 1) {
        return $this->handler->incr($key, $by);
    }
	
    protected function parseConfig($config = '') {
        if (empty($config)) {
            $config = array(
                'type'  =>  C('CACHE_TYPE'),
                'port'  =>  C('CACHE_PORT'),
                'host'  =>  C('CACHE_HOST'),
                'time'  =>  C('CACHE_TIME')
            );
        } elseif (is_array($config)) {
            $config = array(
                'type'  =>  $config['cache_type'],
                'port'  =>  $config['cache_port'],
                'host'  =>  $config['cache_host'],
                'time'  =>  $config['cache_time']
            );
        }
        return $config;
    }
}
