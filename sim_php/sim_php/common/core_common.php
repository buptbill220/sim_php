<?php
function get_config() {
    static $config = null;
    if ($config == null) {
        $config = require_once(FM_SIM_CORE . 'convention.php');
        $config = format_config($config);
    }
    return $config;
}

function format_config($config) {
    if (!is_array($config)) {
        return $config;
    }
    $conf = array();
    foreach ($config as $key => &$value) {
        $conf[strtolower($key)] = format_config($value);
    }
    return $conf;
}
function get_instance_of($name, $method='', $args=array()) {
    static $_instance = array();
    $identify = empty($args) ? $name . $method : $name . $method . to_guid_string($args);
    if (!isset($_instance[$identify])) {
        if (class_exists($name)) {
            $o = new $name();
            if (method_exists($o, $method)) {
                if (!empty($args)) {
                    $_instance[$identify] = call_user_func_array(array(&$o, $method), $args);
                } else {
                    $_instance[$identify] = $o->$method();
                }
            } else 
                $_instance[$identify] = $o;
            }
        else {
            die("class $name not found!");
        } 
    }
    return $_instance[$identify];
}

/*
   从配置中获取值
   */
function C($name = null, $value = null) {
    if ($name == null) {
        return $value;
    }
    static $config = null;
    if ($config == null) {
        $config = get_config();
    }
    $cf = $config;
    $names = explode('.', $name);
    foreach ($names as $nm) {
        $nm = strtolower($nm);
        if (isset($cf[$nm])) {
            $cf = $cf[$nm];
            continue;
        }
        return $value;
    }
    return $cf;
}
// 根据PHP各种类型变量生成唯一标识号
function to_guid_string($mix) {
    if (is_object($mix) && function_exists('spl_object_hash')) {
        return spl_object_hash($mix);
    } elseif (is_resource($mix)) {
        $mix = get_resource_type($mix) . strval($mix);
    } else {
        $mix = serialize($mix);
    }
    return md5($mix);
}

function parse_name($name, $type=0) {
    if ($type) {
        return ucfirst(preg_replace("/_([a-zA-Z])/e", "strtoupper('\\1')", $name));
    } else {
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}
// 设置和获取统计数据
function N($key, $step=0) {
    static $_num = array();
    if (!isset($_num[$key])) {
        $_num[$key] = 0;
    }
    if (empty($step))
        return $_num[$key];
    else
        $_num[$key] = $_num[$key] + (int) $step;
}
//统计时间
function G($start,$end='',$dec=4) {
    static $_info = array();
    if(is_float($end)) { // 记录时间
        $_info[$start]  =  $end;
    }elseif(!empty($end)){ // 统计时间
        if(!isset($_info[$end])) $_info[$end]   =  microtime(TRUE);
        return number_format(($_info[$end]-$_info[$start]),$dec);
    }else{ // 记录时间
        $_info[$start]  =  microtime(TRUE);
    }
}

// 循环创建目录
function mk_dir($dir, $mode = 0777) {
    if (is_dir($dir) || @mkdir($dir, $mode)) 
        return true;
    if (!mk_dir(dirname($dir), $mode))
        return false;
    return @mkdir($dir, $mode);
}

// 获取客户端IP地址
function get_client_ip() {
    static $ip = NULL;
    if ($ip !== NULL) return $ip;
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos =  array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip   =  trim($arr[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

function D($name='') {
    if(empty($name)) return new Model;
    
    static $_model = array();
    if(isset($_model[$name]))
        return $_model[$name];

    $class = $name . "Model";
    if(class_exists($class)) {
        $model = new $class();
    } else {
        $model = new Model;
    }
    $_model[$name]  =  $model;
    return $model;
}

function M($name='', $tablePrefix='',$connection='') {
    static $_model = array();
    if (!isset($_model[$name]))
        $_model[$name] = new Model($name, C('DB_PREFIX'), '');
    return $_model[$name];
}


