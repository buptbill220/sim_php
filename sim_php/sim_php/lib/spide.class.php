<?php

require_once('Http.php');

class Spide {
    protected $_is_login;   //是否登陆
    protected $_is_domain_valid;    //域名是否有效
    protected $_url;        //当前url
    protected $_site;       //当前站点
    protected $_cookie;
    protected $_is_ssl;
    protected $_start_time; //
    protected $_cost_time;
    protected $_total_page; //已经爬取的网页数
    protected $_valid_page; //爬取成功的网页数

    protected $_curl_handler;
    
    public function __construct() {
        $this->_is_login = false;
        $this->_is_domain_valid = true;
        $this->_url = '';
        $this->_site = '';
        $this->_is_ssl = false;
        $this->_start_time = 0;
        $this->_cost_time = 0;
        $this->_total_page = 0;
        $this->_valid_page = 0;
        $this->curl_handler = new Http();
    }

    public function setUrl($url) {
        $this->_url = $url;
        $ret = $this->curl_handler->getSite($url, $with_ssl);
        if ($ret) {
            $this->_site = $ret;
            $this->_is_ssl = (URL_SSL == $with_ssl);
            return true;
        }
        $this->_is_domain_valid = false;
        return false;
    }

    public function ping() {
        $ret = $this->curl_handler->nobody()->header()->run($this->_site());
        if (!$ret) {
            $this->_is_domain_valid = false;
            return false;
        }
        
        if ($this->curl_handler->getStatus() >= 400) {
            $this->_is_domain_valid = false;
            return false;
        }
        $this->_is_domain_valid = true;
    }

    public function run() { }
}
