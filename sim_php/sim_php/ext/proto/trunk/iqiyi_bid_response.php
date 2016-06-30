<?php
require_once('const.php');
require_once('BaseClass.php');

class Settlement extends BaseClass {
	//optional uint32 version = 1;
	public $version;
	public $version_prt = array(2,5,1,'packed' => false);
	function has_version() {
		if (isset($this->version))	return true;
		return false;
	}
	function clear_version() {
		if (isset($this->version))
			unset($this->version);
	}
	//required bytes price = 2;
	public $price;
	public $price_prt = array(1,15,2,'packed' => false);
	function clear_price() {
		if (isset($this->price))
			unset($this->price);
	}
	//optional bytes auth = 3;
	public $auth;
	public $auth_prt = array(2,15,3,'packed' => false);
	function has_auth() {
		if (isset($this->auth))	return true;
		return false;
	}
	function clear_auth() {
		if (isset($this->auth))
			unset($this->auth);
	}
}
class Bid extends BaseClass {
	//required string id = 1;
	public $id;
	public $id_prt = array(1,14,1,'packed' => false);
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//required string impid = 2;
	public $impid;
	public $impid_prt = array(1,14,2,'packed' => false);
	function clear_impid() {
		if (isset($this->impid))
			unset($this->impid);
	}
	//required int32 price = 3;
	public $price;
	public $price_prt = array(1,3,3,'packed' => false);
	function clear_price() {
		if (isset($this->price))
			unset($this->price);
	}
	//required string adm = 6;
	public $adm;
	public $adm_prt = array(1,14,6,'packed' => false);
	function clear_adm() {
		if (isset($this->adm))
			unset($this->adm);
	}
	//optional string adomain = 7;
	public $adomain;
	public $adomain_prt = array(2,14,7,'packed' => false);
	function has_adomain() {
		if (isset($this->adomain))	return true;
		return false;
	}
	function clear_adomain() {
		if (isset($this->adomain))
			unset($this->adomain);
	}
	//required string crid = 10;
	public $crid;
	public $crid_prt = array(1,14,10,'packed' => false);
	function clear_crid() {
		if (isset($this->crid))
			unset($this->crid);
	}
	//optional Settlement settlement = 12;
	public $settlement;
	public $settlement_prt = array(2,'class',12,'Settlement','packed' => false);
	function has_settlement() {
		if (isset($this->settlement))	return true;
		return false;
	}
	function clear_settlement() {
		if (isset($this->settlement))
			unset($this->settlement);
	}
	//optional uint64 dsp = 13;
	public $dsp;
	public $dsp_prt = array(2,6,13,'packed' => false);
	function has_dsp() {
		if (isset($this->dsp))	return true;
		return false;
	}
	function clear_dsp() {
		if (isset($this->dsp))
			unset($this->dsp);
	}
	//optional int64 dsp_id = 14;
	public $dsp_id;
	public $dsp_id_prt = array(2,4,14,'packed' => false);
	function has_dsp_id() {
		if (isset($this->dsp_id))	return true;
		return false;
	}
	function clear_dsp_id() {
		if (isset($this->dsp_id))
			unset($this->dsp_id);
	}
	//optional int32 final_bidfloor = 15;
	public $final_bidfloor;
	public $final_bidfloor_prt = array(2,3,15,'packed' => false);
	function has_final_bidfloor() {
		if (isset($this->final_bidfloor))	return true;
		return false;
	}
	function clear_final_bidfloor() {
		if (isset($this->final_bidfloor))
			unset($this->final_bidfloor);
	}
	//optional int32 startdelay = 16;
	public $startdelay;
	public $startdelay_prt = array(2,3,16,'packed' => false);
	function has_startdelay() {
		if (isset($this->startdelay))	return true;
		return false;
	}
	function clear_startdelay() {
		if (isset($this->startdelay))
			unset($this->startdelay);
	}
	//optional int32 duration = 17;
	public $duration;
	public $duration_prt = array(2,3,17,'packed' => false);
	function has_duration() {
		if (isset($this->duration))	return true;
		return false;
	}
	function clear_duration() {
		if (isset($this->duration))
			unset($this->duration);
	}
}
class Seatbid extends BaseClass {
	//repeated Bid bid = 1;
	public $bid;
	public $bid_prt = array(3,'class',1,'Bid','packed' => false);
	function size_bid() {
		if (isset($this->bid))	return count($this->bid);
		return 0;
	}
	function bid($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_bid())
			return false;
		$bid = $this->bid;
		return $bid[$index];
	}
	function add_bid($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof Bid) {
			$this->bid[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of Bid";
		return false;
	}
	function clear_bid() {
		if (isset($this->bid))
			unset($this->bid);
	}
}
class BidResponse extends BaseClass {
	//required string id = 1;
	public $id;
	public $id_prt = array(1,14,1,'packed' => false);
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//repeated Seatbid seatbid = 2;
	public $seatbid;
	public $seatbid_prt = array(3,'class',2,'Seatbid','packed' => false);
	function size_seatbid() {
		if (isset($this->seatbid))	return count($this->seatbid);
		return 0;
	}
	function seatbid($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_seatbid())
			return false;
		$seatbid = $this->seatbid;
		return $seatbid[$index];
	}
	function add_seatbid($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof Seatbid) {
			$this->seatbid[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of Seatbid";
		return false;
	}
	function clear_seatbid() {
		if (isset($this->seatbid))
			unset($this->seatbid);
	}
	//optional int32 processing_time_ms = 4;
	public $processing_time_ms;
	public $processing_time_ms_prt = array(2,3,4,'packed' => false);
	function has_processing_time_ms() {
		if (isset($this->processing_time_ms))	return true;
		return false;
	}
	function clear_processing_time_ms() {
		if (isset($this->processing_time_ms))
			unset($this->processing_time_ms);
	}
}
?>