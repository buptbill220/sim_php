<?php
if (!defined('FM_SIM_PHP')) die ('undefied FM_SIM_PHP');

class DownloadAction extends Action {
    function index() {
        $session = $_GET['session'];
        $uid = $_GET['uid'];
        $img = $_GET['img'];
        if (!isset($session) || !isset($uid) || !isset($img)) {
            header("HTTP/1.0 404 Not Found");
            return ;
        }
        $http = new Http();
        if (!$http->initCurl()) {
            header("HTTP/1.0 404 Not Found");
            return ;
        }
        $ret = $http->run("http://10.171.84.136/redis/raw?get $uid");
        if (!$ret) {
            header("HTTP/1.0 404 Not Found");
            return ;
        }

        if ($session === $http->getResponse()) {
            $up = new ImageManager;
            $img_name = urldecode($img);
            //$img_name = "default/male.gif";
            $data = $up->download_img($img_name);
            if (false === $data) {
                header("HTTP/1.0 404 Not Found");
                return ;
            }
            ob_clean();
            $this->assign("img_data", $data);
            $ext = pathinfo($img_name);
            $this->assign("img_type", $ext['extension']);
            $this->display('index');
            return ;
        }
        header("HTTP/1.0 404 Not Found");
    }
}
