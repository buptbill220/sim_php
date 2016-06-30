<?php
class Http {
    //used to check url is illegal or not
    const URL_PATTERN = '/^(https?):\/\/[\w-]+(\.[\w-]+)+(\/|\?).*$/';
    //used to get site
    const SITE_PATTERN = '/^(https?):\/\/[\w-]+(\.[\w-]+)+/';

    const URL_GET = 0;
    const URL_POST = 1;

    const URL_NOSSL = 0;
    const URL_SSL = 1;

    /*
       error no. definition while encounterd error
       */
    const ERROR_NO = 0;             //no error
    const ERROR_INIT_ERROR = 1;
    const ERROR_CALLBACK_INVALID = 2;   //callback function invalid
    const ERROR_URL_INVALID = 3;    //url invalied
    const ERROR_URL_UNCONNECT = 4;  //url not arrival
    const ERROR_CURL_TIMEOUT = 5;   //curl timeout
    const ERROR_CURL_ERROR = 6;     //curl error

    private $_curl;
    private $_url;
    private $_cookie;
    private $_http_code;
    private $_http_res;
    private $_site;
    private $_error_no;
    private $_error_msg;
    private $_start_time;
    private $_cost_time;


    public function __construct() {
        $this->_curl = null;
        $this->_url = '';
        $this->_cookie = '';
        $this->_http_code = 200;
        $this->_http_res = '';
        $this->_domain = '';
        $this->_domain_is_valid = '';
        $this->_error_no = self::ERROR_NO;
        $this->_error_msg = '';
        $this->_start_time = 0;
        $this->_cost_time = 0;
    }

    public function initCurl() {
        if ($this->_curl) {
            curl_close($this->_curl);
            $this->_curl = null;
        }
        //temp var is efficient
        $curl = curl_init();
        if ($curl) {
            $this->_curl = $curl;
            return true;
        }
        $this->_error_no = self::ERROR_INIT_ERROR;
        $this->_error_msg = "curl init error";
        return false;
    }

    public function checkUrl($url, &$with_ssl = self::URL_NOSSL) {
        $ret = preg_match(self::SITE_PATTERN, $url, $matches);
        if ($ret) {
            $with_ssl = $this->checkSSL($matches[1]);
            return true;
        }
        return false;
    }

    private function checkSSL($protocol) {
        if ("https" === $protocol) {
            return self::URL_SSL;
        }
        return self::URL_NOSSL;
    }

    public function getSite($url, &$with_ssl = self::URL_NOSSL) {
        $ret = preg_match(self::SITE_PATTERN, $url, $matches);
        if ($ret) {
            $with_ssl = $this->checkSSL($matches[1]);
            return $matches[0];
        }
        return false;
    }

    public function post($data) {
        $param = &$data;
        if (is_array($data)) {
            $param = '';
            foreach ($data as $key => &$value) {
                $param .= '&' . $key . '=' . urlencode($value);
            }
            $param = substr($param, 1);
        }
        curl_setopt($this->_curl, CURLOPT_POST, true);
        curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $param);
        return $this;
    }

    public function run($url, $callback_func = '') {
        $this->_start_time = getCusTime();
        //检url是否有效
        if (!$this->checkUrl($url, $with_ssl)) {
            $this->_error_no = self::ERROR_URL_INVALID;
            $this->_error_msg = 'invalid url';
            return false;
        }
        if (self::URL_SSL == $with_ssl) {
            curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, true);
        }
        $this->_url = $url;
        curl_setopt($this->_curl, CURLOPT_URL, $this->_url);
        if (!empty($callback_func)) {
            if (is_callable($callback_func)) {
                $res = $callback_func($this->_curl);
                $this->_http_res = $res;
            } else {
                $this->_error_no = self::ERROR_CALLBACK_INVALID;
                $this->_error_msg = 'callback function invalid';
                return false;
            }
        } else {
            curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($this->_curl);
            if (false === $res) {
                $this->_error_no = self::ERROR_CURL_ERROR;
                $this->_error_msg = 'curl failed';
                return false;
            }
            $this->_http_res = $res;
            $status = curl_getinfo($this->_curl, CURLINFO_HTTP_CODE);
            $this->_http_code = $status;
        }
        //每次run后，重新设置curl，避免上次的设置污染这次
        if (!self::initCurl()) {
            return false;
        }
        return true;
    }

    /*
       Batching set header
       */
    public function headers($data) {
        curl_setopt($this->_curl, CURLOPT_HTTPHEADER, $data);
        return $this;
    }

    public function useragent($ua) {
        curl_setopt($this->_curl, CURLOPT_USERAGENT, $ua);
        return $this;
    }

    public function refer($ref) {
        curl_setopt($this->_curl, CURLOPT_REFERER, $ref);
        return $this;
    }

    public function ssl($cer = './.client.pem', $key = './.keyout.pem', $cai = './.cai.pem') {
        curl_setopt($this->_curl, CURLOPT_SSLCERT, $cer);
        curl_setopt($this->_curl, CURLOPT_SSLKEY, $key);
        curl_setopt($this->_curl, CURLOPT_CAINFO, $cai);
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, true);
        return $this;
    }
    
    /*
       if you want to set or get cookie
       */
    public function cookie($use_file = false, $cookie = false){
        if ($use_file) {
            curl_setopt($this->_curl, CURLOPT_COOKIEJAR, $cookie);
            curl_setopt($this->_curl, CURLOPT_COOKIEFILE, $cookie);
        } else {
            curl_setopt($this->_curl, CURLOPT_COOKIE, $cookie);
        }
        return $this;
    }

    /* don't need to get response body to output*/
    public function nobody() {
        curl_setopt($this->_curl, CURLOPT_NOBODY, true);
        return $this;
    }

    /* get response header to output*/
    public function header() {
        curl_setopt($this->_curl, CURLOPT_HEADER, true);
        return $this;
    }

    public function timeout($timeout = 5) {
        curl_setopt($this->_curl, CURLOPT_TIMEOUT, $timeout);
        return $this;
    }

    public function getStatus() {
        return $this->_http_code;
    }

    public function getResponse() {
        return $this->_http_res;
    }

    public function getErrorMsg() {
        return $this->_error_msg;
    }
}
