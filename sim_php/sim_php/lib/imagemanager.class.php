<?php
class ImageManager {
    public static $g_img_conf = array(
            'img_types' => array( 'jpg' , 'gif' , 'bmp' , 'jpeg' , 'pjpeg' , 'png' , 'x-png' ),
            'img_limt' => array( 'min' => 1000 , 'max' => 1000000 ),
            'img_size' => array( 'width' => '150px' , 'height' => '150px' ),
            'img_upload' => '/upload/img/',
            'img_default' => array('male' => 'default/male.gif', 'female' => 'default/female.gif')
    );
    private $img_path;
    private $img_name = false;
    private $img_tmp_name = false;
    private $datetime;
    private $img_type;
    private $cache;
    
    function __construct(){
        $this->datetime = $this->set_datatime();
        $this->img_path = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . ImageManager::$g_img_conf['img_upload'];
        $this->cache = Cache::getInstance();
        $this->cache->init();
    }
    private function set_datatime(){
        return date("Y-m-d");
    }
    function set_img_type( $imgname ){
        $fileParts = pathinfo($imgname);
        $this->img_type = $fileParts['extension'];
        $this->img_tmp_name = $imgname;
    }
    function get_img_name(){
        return $this->img_name;
    }
    function get_img_path(){
        return $this->img_path;
    }
    function set_img_path(){
        $branch = $this->cache->get('img_branch');
        if (false === $branch) {
            $branch = 'aa';
            $this->cache->set('img_branch', $branch, 864000);
        } else {
            $i = ord($branch[0]); $j = ord($branch[1]);
            ++$j;
            if ($j > 122) {
                ++$i;
                $j = 97;
            }
            if ($i > 122) {
                $i = 97;
            }
            $branch = chr($i) . chr($j);
            $this->cache->replace('img_branch', $branch);
        }
        $md5 = md5($this->img_tmp_name . $this->datetime . "_" . uniqid(mt_rand(), true));
        $this->img_name = $this->datetime . '/' . $branch . '/' . $md5 . "." . $this->img_type;
    }
    function check_path(){
        $full_name = $this->img_path . $this->img_name;
        if(!file_exists($full_name)){
            mk_dir(dirname($full_name));
        }
    }
    function check_size( $size ){
        if( $size > ImageManager::$g_img_conf['img_limt']['max'] || $size < ImageManager::$g_img_conf['img_limt']['min'] ){
            $this->show_error($size."上传图片超过1000KB或销小于10KB");
        }
    }
    function check_type(){
        if( !in_array($this->img_type,ImageManager::$g_img_conf['img_types']) ){
            $this->show_error("上传图片类型错误");
        }
    }
    function up_photo( $img_tmp ){
        if(!move_uploaded_file($img_tmp, $this->img_path.$this->img_name)){
            $this->show_error("上传文件出错");
        }
    }
    function show_error($errorstr){
        $data = array("result"=>"failed", "msg"=>$errorstr);
        echo $data;
        exit();
    }
    function upload_img( $file_handle){
        $this->set_img_type($file_handle['name']);
        $this->check_type();
        $this->set_img_path();
        $this->check_path();
        $this->check_size($file_handle['size']);
        $this->up_photo($file_handle['tmp_name']);
        $this->read_img($this->img_name);
    }
    
    public function download_img($img) {
        if (isset(ImageManager::$g_img_conf['img_default'][$img])){
            return self::read_img($this->img_path . ImageManager::$g_img_conf['img_default'][$img]);
        }
        $data = self::read_img($img);
        return $data;
    }
    
    public function read_img($img) {
        $data = $this->cache->get($img);
        if ($data !== false) {
            return $data;
        }
        if (!file_exists($this->img_path . $img)) {
            return false;
        }
        $file_size = filesize($this->img_path . $img);
        $fp = fopen($this->img_path . $img, "rb");
        if (!$fp) {
            return false;
        }
        $data = fread($fp, $file_size);
        fclose($fp);
        $this->cache->set($img, $data, 86400);
        return $data;
    }
}
