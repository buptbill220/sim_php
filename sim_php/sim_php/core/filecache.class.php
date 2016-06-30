<?php
class FileCache extends Cache {
    private $filename = '';
    private $file_exist = false;
    private $contents = null;

    public function __construct($config = '') {}

    public function init() {
        $filename = FM_SIM_TMP . '.cache.txt';
		if (!file_exists($filename)) {
            $fp = fopen($filename, "w");
            if (!$fp) {
                throw new Errorexp("can't open file $filename", $this);
            }
			fclose($fp);
        }
        echo $filename;
        $file_exist = true;
		$this->filename = $filename;
        return true;
    }

    public function get($key) {
        $this->flushContent();
        if (isset($this->contents[$key])) {
            $v = $this->contents[$key];
            if ($v['st'] + $v['ct'] >= time()) {
                return $v['v'];
            }
            unset($this->contents[$key]);
            file_put_contents($this->filename, json_encode($this->contents), LOCK_EX);
        }
        return false;
    }

    private function flushContent() {
        if ($this->contents === null) {
            $contents = file_get_contents($this->filename);
            $contents = json_decode($contents, true);
            $this->contents = $contents;
        }
    }
    public function set($key, $value, $cache_time = 86400) {
        $this->flushContent();
        $time = time();
        $this->contents[$key] = array(
                'st'    => $time,
                'v'     => $value,
                'ct'    => $cache_time
                );
        file_put_contents($this->filename, json_encode($this->contents), LOCK_EX);
    }

    public function replace($key, $value) {
        $this->flushContent();
        $old = $this->contents[$key];
        $this->contents[$key] = array(
                'st'    => time(),
                'v'     => $value,
                'ct'    => $old['ct']
                );
        file_put_contents($this->filename, json_encode($this->contents), LOCK_EX);
    }

    public function incr($key, $by = 1) {
        $this->flushContent();
        $old = $this->contents[$key];
        $this->contents[$key] = array(
                'st'    => time(),
                'v'     => $value,
                'ct'    => $old['ct'] + $by
                );
        file_put_contents($this->filename, json_encode($this->contents), LOCK_EX);
        return $old['ct'] + $by;
    }
}
