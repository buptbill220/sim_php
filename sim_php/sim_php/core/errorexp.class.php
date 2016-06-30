<?php
class Errorexp extends Exception {
    private $emsg;
    public function errorMessage() {
        $msg = date('Y/m/d H:i:s') . ' Error on line ' . $this->getLine() . ' in ' . $this->getFile() .
               ': ' . $this->emsg . "\n";
        return $msg;
    }
    function __construct($msg = '', $obj = null) {
        if ($obj instanceof Base) {
            $this->emsg = $obj->getClassMsg($msg);
        } else {
            $this->emsg = $msg;
        }
    }
}
