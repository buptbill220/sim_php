<?php
/**
 +------------------------------------------------------------------------------
 * 该文件请不要修改，如果要覆盖惯例配置的值，可在项目配置文件中设定和惯例不符的配置项
 * 配置名称大小写任意，系统会统一转换成小写
 * create by fangming.fm@alibaba-inc.com
 +------------------------------------------------------------------------------
 */
//if (!defined('THINK_PATH')) exit();
return  array(
    /* Cookie设置 */
    'COOKIE_EXPIRE'         => 3600,    // Coodie有效期
    'COOKIE_DOMAIN'         => '',      // Cookie有效域名
    'COOKIE_PATH'           => '/',     // Cookie路径
    'COOKIE_PREFIX'         => '',      // Cookie前缀 避免冲突

    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
    'DB_HOST'               => 'localhost', // 服务器地址
    'DB_NAME'               => 'bupt',          // 数据库名
    'DB_USER'               => 'root',      // 用户名
    'DB_PWD'                => '',          // 密码
    'DB_PORT'               => '',        // 端口
    'DB_PREFIX'             => 'st_',    // 数据库表前缀
    'DB_SUFFIX'             => '',          // 数据库表后缀
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         => 1, // 读写分离后 主服务器数量

    /* cache设置*/
    'CACHE_TYPE'            => 'Redis',  //cache类型File or Memcache
    'CACHE_PORT'            => 12345,   //memcache端口
    'CACHE_HOST'            => '127.0.0.1', //memcache 地址
    'CACHE_TIME'            => 300,

    /* SESSION设置 */
    'SESSION_AUTO_START'    => true,    // 是否自动开启Session
    'VAR_SESSION_ID'        => 'session_id',     //sessionID的提交变量
    'ART_PAGE'              => 20,
    'CHEAT_NUM'             => 10,
    'REDIS_PASS'            => 'xxxxxxxx'
);
