<?php
class FONT {
    const NORMAL    = 0;
    const INFO      = 1;
    const SUCCESS   = 2;
    const ERROR     = 3;
    const DEBUG     = 4;
    const REVERS    = 5;
    const CLOSE     = 6;

    public static function  setNormal($hasGlint = false, $hasLine = false) {
        self::setFont(self::NORMAL, $hasGlint, $hasLine);
    }

    public static function  setInfo($hasGlint = false, $hasLine = false) {
        self::setFont(self::INFO, $hasGlint, $hasLine);
    }

    public static function  setSuccess($hasGlint = false, $hasLine = false) {
        self::setFont(self::SUCCESS, $hasGlint, $hasLine);
    }

    public static function  setError($hasGlint = false, $hasLine = false) {
        self::setFont(self::ERROR, $hasGlint, $hasLine);
    }

    public static function  setDebug($hasGlint = false, $hasLine = false) {
        self::setFont(self::DEBUG, $hasGlint, $hasLine);
    }

    public static function setRevers($hasGlint = false, $hasLine = false) {
        self::setFont(self::REVERS, $hasGlint, $hasLine);
    }

    public static function setClose($hasGlint = false, $hasLine = false) {
        self::setFont(self::CLOSE, $hasGlint, $hasLine);
    }

    public static function  setFont($mode = self::NORMAL, $hasGlint = false, $hasLine = false ) {
        $set = '';
        switch ($mode) {
            case self::NORMAL:
                $set = CONF::F_OPEN . CONF::F_BACK . CONF::F_B_BLK . CONF::F_FORE . CONF::F_F_WHT;
                break;
            case self::INFO:
                $set = CONF::F_OPEN . CONF::F_BACK . CONF::F_B_BLK . CONF::F_FORE . CONF::F_F_BLUE;
                break;
            case self::SUCCESS:
                $set = CONF::F_OPEN . CONF::F_BACK . CONF::F_B_BLK . CONF::F_FORE . CONF::F_F_GREN;
                break;
            case self::ERROR:
                $set = CONF::F_OPEN . CONF::F_BACK . CONF::F_B_BLK . CONF::F_FORE . CONF::F_F_RED;
                break;
            case self::DEBUG:
                $set = CONF::F_OPEN . CONF::F_BACK . CONF::F_B_BLK . CONF::F_FORE . CONF::F_F_YELL;
                break;
            case self::REVERS:
                $set = CONF::F_OPEN . CONF::F_BACK . CONF::F_B_WHT . CONF::F_FORE . CONF::F_F_BLK;
                break;
            default:
                $set = CONF::F_CLOSE;
        }
        if ($hasGlint)  $set = $set . CONF::F_GLINT;
        if ($hasLine)   $set = $set . CONF::F_LINE;
        echo $set;
    }
}
