<?php
ob_start();
session_start();
date_default_timezone_set('PRC');
if (!defined('APP_NAME')) {
    die ('undefined app name');
}

require_once('define.php');
require_once(FM_SIM_CORE . 'autoload.class.php');
$loader = Autoload::init(FM_SIM_PATH);
Autoload::requireAll(FM_SIM_COMMON);
Autoload::requireAll(FM_SIM_EXT);
if ('sim_php' === APP_NAME) {
    die ('app name must not be equal to framework path');
}

if (!defined('APP_PATH')) {
    define('APP_PATH', APP_NAME);
}
if (!isset($_GET['_sertype'])) {
    header('HTTP/1.1 404 Not Found');
    return ;
}
$action = $_GET['_sertype'];
if (!isset($_GET['argv']) || empty($_GET['argv'])) {
    $method = 'index';
} else {
    $method = $_GET['argv'];
}
if ($method === "" || $method === "/") {
    $method = "index";
}
if (!preg_match('/^\w+$/', $method)) {
    header('HTTP/1.1 404 Not Found');
    return ;
}

$action_apth = ROOT_PATH . APP_PATH . '/' . __ACTION__;
$model_path = ROOT_PATH . APP_PATH . '/' . __MODEL__;
$tpl_path = ROOT_PATH . APP_PATH . '/' . __TPL__ . $action . '/';

define('CUR_ACTION_PATH', $action_apth);
define('CUR_MODEL_PATH', $model_path);
define('CUR_TPL_PATH', $tpl_path);
$action_file = $action_apth . $action . 'action.class.php';

if (!file_exists($action_file)) {
    header('HTTP/1.1 404 Not Found');
    return ;
}

$loader->load($action_apth);
$loader->load($model_path);
set_include_path(get_include_path() . PATH_SEPARATOR . $tpl_path);

$action_class = ucfirst($action) . 'Action';
if (!class_exists($action_class))  {
    $action_class = $action . 'Action';
}

if (!class_exists($action_class)) {
    header('HTTP/1.1 404 Not Found');
    return ;
}
$act = $action;
$action = new $action_class;
if (!method_exists($action, $method)) {
    $action->error();
    return ;
}
$cache = Cache::getInstance();
$cache->init();

$cheat = new Cheat;
if (false === $cheat->check()) {
    echo "you are cheating!!!";
    header('HTTP/1.1 404 Not Found');
    return ;
}
$key = $act . "_" . $method;
$arrpv = 1;
if (false === $cache->get($key)) {
    $cache->set($key, 1);
} else {
    $arrpv = $cache->incr($key);
}
$action->assign("arrpv", $arrpv);
$action->$method();
