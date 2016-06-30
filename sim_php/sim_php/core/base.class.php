<?php
class Base {
    public function getClassMsg($msg) {
        $msg = $msg . ' in ' . get_class($this) . '::' . __METHOD__ . ' ';
        return $msg;
    }
}
