<?php
function getTime($mode = 1) {
    list($mic, $sec) = explode(' ', microtime());
    switch ($mode) {
        case 1:  $time = $sec; break;
        case 2:  $time = $mic; break;
        case 3:
        default: $time = $sec + $mic; break;
    }
    return $time;
}

function getCusTime($flag = false) {
    static $s = 0;
    if ($flag) {
        $e = getTime(3);
        return ($e - $s);
    }
    $s = getTime(3);
    return $s;
}

function getCusMem($flag = false, $real = false) {
    static $f = 0;
    if ($flag) {
        $l = memory_get_usage($real);
        return ($l - $f);
        }
    $f = memory_get_usage($real);
    return $f;
}
    //my format dump funciton (output to html)
function dump($array){
    $str = my_dump($array,0);
    echo $str;
}

function my_dump($array, $left = 0){
    $pad = str_pad('', $left, ' ', STR_PAD_LEFT);

    if( !isset($array) )
        $tmp = "not set\n";
    elseif( is_array($array) ){
        $tmp = "array {\n";
        foreach( $array as $idx => $ele ){
            $tmp .= $pad . '    ' . get_format_type($idx) . ' => ';
            $tmp .= my_dump($ele, $left + 4);
        }
        $tmp .= $pad . "}\n";
    }
    elseif( is_object($array) ){
        $tmp = "object => {\n";
        $vars = get_object_vars($array);
        $tmp .= '    ' . my_dump($vars, $left + 4);
            $tmp .= $pad . "}\n";
    }else{
        $tmp = get_format_type($array) . "\n";
    }
    return $tmp;
}

function html_dump($array){
    $str = "<pre style='float:none;clear:both;width:95%;background:#bbb;color:#111'>";
    $str .= my_dump_h($array,0);
    $str .= "</pre>";
    echo $str;
}

function my_dump_h($array, $left = 0){
    if( !isset($array) )
        $tmp = "not set\n";
    elseif( is_array($array) ){
        $tmp = "\n<span style='margin-left:{$left}px'></span>{\n";
        $left += 20;
        foreach( $array as $idx => $ele ){
            $tmp .= "<span style='margin-left:{$left}px'>" . get_format_type($idx) . "  =>  ";
            $tmp .= my_dump_h($ele, $left) . "</span>";
        }
        $left -= 20;
        $tmp .= "<span style='margin-left:{$left}px'>}</span>\n";
    }
    elseif( is_object($array) ){
        $tmp = "\"object\"  =>  ";
        $vars = get_object_vars($array);
        $tmp .= my_dump_h($vars, $left);
    }else{
        $tmp = get_format_type($array) . "\n";
    }
    return $tmp;
}

function get_format_type($ele){
	switch(gettype($ele)){
        case "string":$tmp = "\"$ele\"";break;
        case "resource":$tmp = "#resource:$ele";break;
        case "NULL":$tmp = "NULL";break;
        case "object":$tmp = "\"object\":";break;
        case "array":$tmp = "\"array\":";break;
        case "boolean":
        case "integer":
        case "double":
            $tmp = $ele;break;
        default:$tmp = "unknown type";
    }
    return $tmp;
}
function swap(&$p1, &$p2) {
    if (is_numeric($p1) && is_numeric($p2)) {
        $max = max($p1, $p2);
        $p1 = min($p1, $p2);
        $p2 = $max;
    }
}

function getLowerStr($str) {
    static $array = array();
    if (isset($array[$str])) {
        return $array[$str];
    }
    $array[$str] = strtolower($str);
    return $array[$str];
}

function setHomeDir() {
    $home_dir = shell_exec('pwd');
    if (!defined('HOME_DIR')) {
        define('HOMR_DIR', $home_dir);
    }
}

function getCurUser() {
    //$user = shell_exec('echo $USER');
    $user = '';
    return $user;
}

function getID( $id , $default = 1 ){
    if( empty($id) && !is_numeric($id) )
        $id = $default;
    return $id;
}

