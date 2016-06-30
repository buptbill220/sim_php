<?php
class File {
    static function getLastLine($file) {
        //clearstatcache();
        if (!file_exists($file)) {
            return false;
        }
        return (shell_exec('tail -1 ' . $file));
    }
    
    static function getLastAppend($file, $flag = false) {
	    static $file_handler = array();
        //clearstatcache();
        if (!file_exists($file)) {
            return false;
        }
        clearstatcache();
        if (true === $flag) {
		    $size = $file_handler[$file];
            $size1 = filesize($file);
            if ($size1 <= $size) {
                return '';
            }
            $fp = fopen($file, 'r');
            fseek($fp, $size, SEEK_SET);
            $append = fread($fp, $size1 - $size);
            fclose($fp);
            return $append;
        }
        $size = filesize($file);
		$file_handler[$file] = $size;
        return $size;
    }
    
    static function getBetweenLine($file, $start = 1, $end = '$') {
        //clearstatcache();
        if (!file_exists($file)) {
            return false;
        }
        if (($end == '$' || $start == intval($start)) && 
            ($end == '$' || $start == intval($end))) {
            if ($start == $end) {
                $cmd = 'sed -n \'' . $start . 'p\' ' . $file;
            } else {
                $cmd = 'sed -n \'' . $start . ',' . $end . 'p\' ' . $file;
            }
            return (shell_exec($cmd));
        }
        return false;
    }
}