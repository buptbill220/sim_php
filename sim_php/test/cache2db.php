<?php
date_default_timezone_set('PRC');
require_once('../sim_php/define.php');
require_once(FM_SIM_CORE . 'autoload.class.php');
$loader = Autoload::init(FM_SIM_PATH);
Autoload::requireAll(FM_SIM_COMMON);
Autoload::requireAll(FM_SIM_EXT);

$time = date('Y-m-d H:i:s', time());
echo "begin to dump cache to db at time " . $time . "\n";
$db = M('article');
$art = $db->field('id, read, love')->where('enable = 1')->select();
$cache = Cache::getInstance();
$cache->init();
foreach ($art as $a) {
    $key = $a['id'] . 'r';
    $read = $cache->get($key);
    $key = $a['id'] . 'l';
    $love = $cache->get($key);
    if ($read === false && $love === false) {
        continue;
    }
    $sql = "update st_article set modify_time = '$time'";
    if ($read !== false) {
        $sql .= ", `read` = $read";
    }
    if ($love !== false) {
        $sql .= ", `love` = $love";
    }
    $sql .= " where id = {$a['id']}";
    echo $sql . "\n";
    $db->execute($sql);
    echo $db->commit();

}

echo "end to dump cache to db at time " . date('Y-m-d H:i:s', time()) . "\n";
