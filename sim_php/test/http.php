<?php
date_default_timezone_set('PRC');
require_once('../sim_php/define.php');
require_once(FM_SIM_CORE . 'autoload.class.php');
$loader = Autoload::init(FM_SIM_PATH);
Autoload::requireAll(FM_SIM_COMMON);
Autoload::requireAll(FM_SIM_EXT);

$http = new http;
$http->initCurl();
$headers = array('Accept: application/json, text/javascript, */*; q=0.01', 'User-Agent: Mozilla/5.0', 'X-Requested-With: XMLRequest', 'Referer: http://www.zyhtcae.com');
$http->headers($headers)->run('http://120.55.124.178:81/shyhsy/?type=lists&ajax=1');
dump($http->getResponse());

$headers[3] = 'Referer: http://ta.shscce.com:8080/front/hq/delay_hq_cache.htm?stockPreCodes=&indexCodes=600001';
$http->headers($headers)->run('http://ta.shscce.com:8080/front/hq/delay_hq.json?callback=jsonp1465354048527&_=1465354139330&stockPreCodes=&mainIndexCode=&dataIndexCode=');
dump($http->getResponse());
