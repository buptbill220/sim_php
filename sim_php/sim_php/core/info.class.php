<?php
class INFO {
    const NORMAL    = 0;
    const INFO      = 1;
    const SUCCESS   = 2;
    const ERROR     = 3;
    const DEBUG     = 4;
    const REVERS    = 5;

    public static function infoNormal($data, $dump = false, $hasGlint = false, $hasLine = false) {
        self::dump($data, self::NORMAL, $dump, $hasGlint, $hasLine);
    }

    public static function infoInfo($data, $dump = false, $hasGlint = false, $hasLine = false) {
        self::dump($data, self::INFO, $dump, $hasGlint, $hasLine);
    }

    public static function infoSuccess($data, $dump = false, $hasGlint = false, $hasLine = false) {
        self::dump($data, self::SUCCESS, $dump, $hasGlint, $hasLine);
    }

    public static function infoError($data, $dump = false, $hasGlint = false, $hasLine = false) {
        self::dump($data, self::ERROR, $dump, $hasGlint, $hasLine);
    }

    public static function infoDebug($data, $dump = false, $hasGlint = false, $hasLine = false) {
        self::dump($data, self::DEBUG, $dump, $hasGlint, $hasLine);
    }

    public static function infoRevers($data, $dump = false, $hasGlint = false, $hasLine = false) {
        self::dump($data, self::REVERS, $dump, $hasGlint, $hasLine);
    }
    public static function dump($data, $mode = self::NORMAL, $dump = false, $hasGlint = false, $hasLine = false) {
        switch ($mode) {
            case self::NORMAL:  FONT::setNormal($hasGlint, $hasLine);   break;
            case self::INFO:    FONT::setInfo($hasGlint, $hasLine);    break;
            case self::SUCCESS: FONT::setSuccess($hasGlint, $hasLine); break;
            case self::ERROR:   FONT::setError($hasGlint, $hasLine);   break;
            case self::DEBUG:   FONT::setDebug($hasGlint, $hasLine);   break;
            case self::REVERS:  FONT::setRevers($hasGlint, $hasLine);  break;
            default:            FONT::setClose($hasGlint, $hasLine);
        }
        if ($dump) {
            dump($data);
            FONT::setClose();
            return ;
        }
        if (is_array($data) || is_object($data)) {
            var_dump($data);
            FONT::setClose();
            return ;
        }
        echo $data, "\n";
        FONT::setClose();
    }
}
