<?php
class MTdbm{
    private $db = null;
    public function __construct($ftdbm, $flag = true){
        $this->db = null;
        $this->connect_tdbm($ftdbm, $flag);
    }
    public function connect_tdbm($ftdbm, $flag = true){
        $time = filemtime($ftdbm);
        if ($flag) {
            echo "<h5 style='margin-left:20px'>" . basename($ftdbm) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;上次修改时间:&nbsp; " . date("Y-m-d H:i:s",$time) . "</h5>";
        }
        $this->db = tdbm_open($ftdbm, O_RDWR|O_CREAT, 0666, 0, 0);
        if (!$this->db){
            echo("open file $ftdbm failed!");
            exit(-1);
        }
    }
    public function read_data($key){
        tdbm_lock($this->db);
        $value = null;
        $value = tdbm_fetch($this->db, $key);
        tdbm_unlock($this->db);
        return $value;
    }
    public function store_data($key, $value, $type = 'insert'){
        tdbm_lock( $this->db );
        if (empty($key))
            echo "warning: the key is empty\n";
        $way = ($type=="insert")?TDBM_INSERT:TDBM_REPLACE;
        $status = tdbm_store($this->db, $key, $value, $way);
        tdbm_unlock($this->db);
        return $status;
    }
    public function delete_data($key){
        tdbm_lock( $this->db );
        $status = tdbm_delete($this->db, $key);
        tdbm_unlock($this->db);
        return $status;
    }
    public function get_first(){
        return tdbm_first($this->db);
    }
    public function get_next(){
        return tdbm_next($this->db);
    }
    public function get_all(){
        $data = tdbm_first($this->db);
        $re = null;
        if($data){
            $re = array();
            $re[] = $data;
            while(($data=tdbm_next($this->db)))
                $re[] = $data;
        }
        return $re;
    }
    function close_tdbm(){
        tdbm_sync( $this->db );
        tdbm_close( $this->db );
    }
    public function __destruct(){
        $this->close_tdbm();
    }
}
?>
