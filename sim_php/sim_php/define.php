<?php
//definition of my project
define('FM_SIM_PHP', 'wrote by fangming Jan 22th 2015', true);
//pysical path of my project
define('ROOT_PATH', dirname(__FILE__) . '/../');
define('FM_SIM_PATH', ROOT_PATH . 'sim_php/');
define('FM_SIM_CORE', FM_SIM_PATH . 'core/');
define('FM_SIM_LIB', FM_SIM_PATH . 'lib/');
define('FM_SIM_COMMON', FM_SIM_PATH . 'common/');
define('FM_SIM_EXT', FM_SIM_PATH . '/ext/');
define('FM_SIM_LOGS', ROOT_PATH . 'logs/');
define('FM_SIM_TMP', ROOT_PATH . '.cache/');
define('FM_SIM_PUBLIC', ROOT_PATH . 'public');
//app path of my project
define('WEB_ROOT', $_SERVER[ 'DOCUMENT_ROOT']);
define('WEB_HOST', 'http://' . $_SERVER['HTTP_HOST']);
define('__ROOT__', '/');
define('__PUBLIC__', __ROOT__ . 'public/');
define('__IMG__', __PUBLIC__ . 'img/');
define('__CSS__', __PUBLIC__ . 'css/');
define('__JS__', __PUBLIC__ . 'js');
//app definition
define('__ACTION__', 'Action/');
define('__MODEL__', 'Model/');
define('__TPL__', 'Tpl/');
