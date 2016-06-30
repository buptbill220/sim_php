<?php
class Dom extends Base {
    function getInstance() {
        return new Dom;
    }
    
    private function __construct(){}
    
    //if force is true, if property name exist then value will be updated,
    //otherwise it will be stored in array
    function addProperty($name, $value, $force = false) {
        $name = trim(getLowerStr($name));
        $qname = &$this->$name;
        $ret = false;
        if (!isset($qname)) {
            $qname = $value;
            return $ret;
        }
        if (true === $force) {
            unset($qname);
            $qname = &$this->$name;
            $ret = true;
            $qname = $value;
            return $ret;
        }
        if (is_array($qname)) {
            $qname[] = $value;
        } else {
            $qname = array($qname, $value);
        }
        return $ret;
    }
    
    function addData($name, $id, $value, $force = false) {
        $name = trim(getLowerStr($name));
        $id = trim(getLowerStr($id));
        if (empty($name)) {
            echo 'error: id must not be empty in function addData <', $name, ',', $id, ',', $value, "\n";
            return null;
        }
        $qname = &$this->$name;
        $qdata = &$qname[$id];
        $ret = false;
        if (!isset($qdata)) {
            $qdata = $value;
            return $ret;
        }
        }if (true === $force) {
            unset($qdata);
            $qdata = &$qname[$id];
            $ret = true;
            $qdata = $value;
            return $ret;
        }
        if (is_array($qdata)) {
            $qdata[] = $value;
        } else {
            $qdata = array($qdata, $value);
        }
        return $ret;
    }
    function delProperty($name) {
        $name = getLowerStr($name);
        if (isset($this)) {
            unset($this->$name);
        }
    }
    
    function getValue($tag) {
        $tag = getLowerStr($tag);
        return $this->$tag;
    }
}
