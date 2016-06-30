<?php 
class Cheat {
    function check() {
        return $this->check_key(session_id()) && $this->check_key(get_client_ip());
    }

    protected function check_key($key) {
        $cache = Cache::getInstance();
        $time = time();
        $val = $cache->get($key);
        if (false === $val) {
            $val = $time . '_0';
            $cache->set($key, $val, C('CACHE_TIME'));
        }

        $v = explode('_', $val);
        if ($time - $v[0] <= 10 && $v[1] >= C('CHEAT_NUM')) {
            return false;
        }
        if ($time - $v[0] > C('CHEAT_NUM')) {
            $cache->set($key, $time . '_1', C('CACHE_TIME'));
        } else {
            $c = ($v[1]+1);
            $v1 = $v[0] . '_' . $c;
            $cache->set($key, $v1, C('CACHE_TIME'));
        }
        return true;
    }
}
