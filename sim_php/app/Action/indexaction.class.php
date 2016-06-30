<?php
if (!defined('FM_SIM_PHP')) die ('undefied FM_SIM_PHP');

class IndexAction extends Action {
	protected function get_ip_address() {
		$Ip = new IpLocation();
        $ip = get_client_ip();
        $ipinfo = $Ip->getlocation($ip);
        $address = "";
        if ($ipinfo && isset($ipinfo['country'])) {
            $address = $ipinfo['country'];
            if (isset($ipinfo['area'])) {
                $address .= '-' . $ipinfo['area'];
            }
        }
        $this->assign("address", $address);
	}

    function index() {
        $pics = array('images/s.jpg', 'images/s1.jpg', 'images/s2.jpg', 'images/s3.jpg');
        $db = D('Index');
        $art = $db->getArtList(0, 1, 'love,modify_time');
        if (!$art) {
            $art = array();
        }

        $this->assign('pics', $pics);
        $this->assign('pn', 4);
        $this->assign('art', $art);

        $this->get_ip_address();
        $this->display("index");
    }
}
