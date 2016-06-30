<?php
if (!defined('FM_SIM_PHP')) die ('undefied FM_SIM_PHP');

class UploadAction extends Action {
    function index() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo '{"result":"faild", "msg":"must be post"}';
            return ;
        }
        $session = $_GET['session'];
        $uid = $_GET['uid'];
        if (!isset($session) || !isset($uid)) {
            echo '{"result":"failed", "msg":"invalied parameters"}';
            return ;
        }
        $http = new Http();
        if (!$http->initCurl()) {
            echo '{"result":"failed", "msg":"internal error"}';
            return ;
        }
        $ret = $http->run("http://10.171.84.136/redis/raw?get $uid");
        if (!$ret) {
            echo '{"result":"failed", "msg":"internal error"}';
            return ;
        }

		if ($session === $http->getResponse()) {
			$up = new ImageManager;
			$up->upload_img($_FILES['Filedata']);
			echo '{"result":"success", "url":"' . $up->get_img_name() . '"}';
            return ;
		}
		echo '{"result":"failed", "msg":"invalid token"}';
        return ;
    }
}
