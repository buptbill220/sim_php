<?php
if ($argc != 2) {
    echo "php queryip.php ip.txt\n";
    exit(-1);
}

date_default_timezone_set('PRC');
require_once('../sim_php/define.php');
require_once(FM_SIM_CORE . 'autoload.class.php');
$loader = Autoload::init(FM_SIM_PATH);
Autoload::requireAll(FM_SIM_COMMON);
Autoload::requireAll(FM_SIM_EXT);

$ipfile = $argv[1];
$Ip = new IpLocation();
$file = fopen($ipfile, 'r');
if (!$file) {
    echo "open file: $ipfile failed\n";
    exit(-1);
}

while (!feof($file)) {
    $ip = trim(fgets($file));
    $ipinfo = $Ip->getlocation($ip);
    $address = "";
    if ($ipinfo && isset($ipinfo['country'])) {
        $address = $ipinfo['country'];
        if (isset($ipinfo['area'])) {
            $address .= '-' . $ipinfo['area'];
        }
    }
    echo "ip: $ip, address: $address\n";
}
