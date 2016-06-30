<?php
require_once('const.php');
require_once('BaseClass.php');

class Video extends BaseClass {
	//optional int64 ad_zone_id = 1;
	public $ad_zone_id;
	public $ad_zone_id_prt = array(2,4,1,'packed' => false);
	function has_ad_zone_id() {
		if (isset($this->ad_zone_id))	return true;
		return false;
	}
	function clear_ad_zone_id() {
		if (isset($this->ad_zone_id))
			unset($this->ad_zone_id);
	}
	//optional int32 linearity = 3;
	public $linearity;
	public $linearity_prt = array(2,3,3,'packed' => false);
	function has_linearity() {
		if (isset($this->linearity))	return true;
		return false;
	}
	function clear_linearity() {
		if (isset($this->linearity))
			unset($this->linearity);
	}
	//optional int32 minduration = 4;
	public $minduration;
	public $minduration_prt = array(2,3,4,'packed' => false);
	function has_minduration() {
		if (isset($this->minduration))	return true;
		return false;
	}
	function clear_minduration() {
		if (isset($this->minduration))
			unset($this->minduration);
	}
	//optional int32 maxduration = 5;
	public $maxduration;
	public $maxduration_prt = array(2,3,5,'packed' => false);
	function has_maxduration() {
		if (isset($this->maxduration))	return true;
		return false;
	}
	function clear_maxduration() {
		if (isset($this->maxduration))
			unset($this->maxduration);
	}
	//optional int32 protocol = 6;
	public $protocol;
	public $protocol_prt = array(2,3,6,'packed' => false);
	function has_protocol() {
		if (isset($this->protocol))	return true;
		return false;
	}
	function clear_protocol() {
		if (isset($this->protocol))
			unset($this->protocol);
	}
	//optional int32 w = 7 [default = 880];
	public $w = 880;
	public $w_prt = array(2,3,7,880,'packed' => false);
	function has_w() {
		if (isset($this->w))	return true;
		return false;
	}
	function clear_w() {
		if (isset($this->w))
			unset($this->w);
		$this->w = 880;
	}
	//optional int32 h = 8 [default = 495];
	public $h = 495;
	public $h_prt = array(2,3,8,495,'packed' => false);
	function has_h() {
		if (isset($this->h))	return true;
		return false;
	}
	function clear_h() {
		if (isset($this->h))
			unset($this->h);
		$this->h = 495;
	}
	//optional int32 startdelay = 9;
	public $startdelay;
	public $startdelay_prt = array(2,3,9,'packed' => false);
	function has_startdelay() {
		if (isset($this->startdelay))	return true;
		return false;
	}
	function clear_startdelay() {
		if (isset($this->startdelay))
			unset($this->startdelay);
	}
}
class Impression extends BaseClass {
	//optional string id = 1;
	public $id;
	public $id_prt = array(2,14,1,'packed' => false);
	function has_id() {
		if (isset($this->id))	return true;
		return false;
	}
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//optional Video video = 3;
	public $video;
	public $video_prt = array(2,'class',3,'Video','packed' => false);
	function has_video() {
		if (isset($this->video))	return true;
		return false;
	}
	function clear_video() {
		if (isset($this->video))
			unset($this->video);
	}
	//optional int32 bidfloor = 4 [default = 0];
	public $bidfloor = 0;
	public $bidfloor_prt = array(2,3,4,0,'packed' => false);
	function has_bidfloor() {
		if (isset($this->bidfloor))	return true;
		return false;
	}
	function clear_bidfloor() {
		if (isset($this->bidfloor))
			unset($this->bidfloor);
		$this->bidfloor = 0;
	}
}
class Site extends BaseClass {
	//optional uint32 id = 1;
	public $id;
	public $id_prt = array(2,5,1,'packed' => false);
	function has_id() {
		if (isset($this->id))	return true;
		return false;
	}
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//optional Content content = 11;
	public $content;
	public $content_prt = array(2,'class',11,'Content','packed' => false);
	function has_content() {
		if (isset($this->content))	return true;
		return false;
	}
	function clear_content() {
		if (isset($this->content))
			unset($this->content);
	}
}
class Content extends BaseClass {
	//optional string title = 3;
	public $title;
	public $title_prt = array(2,14,3,'packed' => false);
	function has_title() {
		if (isset($this->title))	return true;
		return false;
	}
	function clear_title() {
		if (isset($this->title))
			unset($this->title);
	}
	//optional string url = 6;
	public $url;
	public $url_prt = array(2,14,6,'packed' => false);
	function has_url() {
		if (isset($this->url))	return true;
		return false;
	}
	function clear_url() {
		if (isset($this->url))
			unset($this->url);
	}
	//repeated string keyword = 9;
	public $keyword;
	public $keyword_prt = array(3,14,9,'packed' => false);
	function size_keyword() {
		if (isset($this->keyword))	return count($this->keyword);
		return 0;
	}
	function keyword($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_keyword())
			return false;
		$keyword = $this->keyword;
		return $keyword[$index];
	}
	function add_keyword($ele) {
		if (isset($ele) && $this->validate_type(14, $ele)) {
			$this->keyword[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_keyword() {
		if (isset($this->keyword))
			unset($this->keyword);
	}
	//optional int32 len = 16;
	public $len;
	public $len_prt = array(2,3,16,'packed' => false);
	function has_len() {
		if (isset($this->len))	return true;
		return false;
	}
	function clear_len() {
		if (isset($this->len))
			unset($this->len);
	}
	//optional int64 album_id = 20;
	public $album_id;
	public $album_id_prt = array(2,4,20,'packed' => false);
	function has_album_id() {
		if (isset($this->album_id))	return true;
		return false;
	}
	function clear_album_id() {
		if (isset($this->album_id))
			unset($this->album_id);
	}
	//repeated int64 channel_id = 21 [packed = true];
	public $channel_id;
	public $channel_id_prt = array(3,4,21,'packed' => true);
	function size_channel_id() {
		if (isset($this->channel_id))	return count($this->channel_id);
		return 0;
	}
	function channel_id($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_channel_id())
			return false;
		$channel_id = $this->channel_id;
		return $channel_id[$index];
	}
	function add_channel_id($ele) {
		if (isset($ele) && $this->validate_type(4, $ele)) {
			$this->channel_id[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_channel_id() {
		if (isset($this->channel_id))
			unset($this->channel_id);
	}
}
class Device extends BaseClass {
	//optional string ua = 2;
	public $ua;
	public $ua_prt = array(2,14,2,'packed' => false);
	function has_ua() {
		if (isset($this->ua))	return true;
		return false;
	}
	function clear_ua() {
		if (isset($this->ua))
			unset($this->ua);
	}
	//optional string ip = 3;
	public $ip;
	public $ip_prt = array(2,14,3,'packed' => false);
	function has_ip() {
		if (isset($this->ip))	return true;
		return false;
	}
	function clear_ip() {
		if (isset($this->ip))
			unset($this->ip);
	}
	//optional Geo geo = 4;
	public $geo;
	public $geo_prt = array(2,'class',4,'Geo','packed' => false);
	function has_geo() {
		if (isset($this->geo))	return true;
		return false;
	}
	function clear_geo() {
		if (isset($this->geo))
			unset($this->geo);
	}
	//optional int32 platform_id = 18;
	public $platform_id;
	public $platform_id_prt = array(2,3,18,'packed' => false);
	function has_platform_id() {
		if (isset($this->platform_id))	return true;
		return false;
	}
	function clear_platform_id() {
		if (isset($this->platform_id))
			unset($this->platform_id);
	}
}
class Geo extends BaseClass {
	//optional int32 country = 3;
	public $country;
	public $country_prt = array(2,3,3,'packed' => false);
	function has_country() {
		if (isset($this->country))	return true;
		return false;
	}
	function clear_country() {
		if (isset($this->country))
			unset($this->country);
	}
	//optional int32 metro = 5;
	public $metro;
	public $metro_prt = array(2,3,5,'packed' => false);
	function has_metro() {
		if (isset($this->metro))	return true;
		return false;
	}
	function clear_metro() {
		if (isset($this->metro))
			unset($this->metro);
	}
	//optional int32 city = 6;
	public $city;
	public $city_prt = array(2,3,6,'packed' => false);
	function has_city() {
		if (isset($this->city))	return true;
		return false;
	}
	function clear_city() {
		if (isset($this->city))
			unset($this->city);
	}
}
class User extends BaseClass {
	//optional string id = 1;
	public $id;
	public $id_prt = array(2,14,1,'packed' => false);
	function has_id() {
		if (isset($this->id))	return true;
		return false;
	}
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//optional Geo geo = 5;
	public $geo;
	public $geo_prt = array(2,'class',5,'Geo','packed' => false);
	function has_geo() {
		if (isset($this->geo))	return true;
		return false;
	}
	function clear_geo() {
		if (isset($this->geo))
			unset($this->geo);
	}
}
class BidRequest extends BaseClass {
	//optional string id = 1;
	public $id;
	public $id_prt = array(2,14,1,'packed' => false);
	function has_id() {
		if (isset($this->id))	return true;
		return false;
	}
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//optional User user = 2;
	public $user;
	public $user_prt = array(2,'class',2,'User','packed' => false);
	function has_user() {
		if (isset($this->user))	return true;
		return false;
	}
	function clear_user() {
		if (isset($this->user))
			unset($this->user);
	}
	//optional Site site = 3;
	public $site;
	public $site_prt = array(2,'class',3,'Site','packed' => false);
	function has_site() {
		if (isset($this->site))	return true;
		return false;
	}
	function clear_site() {
		if (isset($this->site))
			unset($this->site);
	}
	//optional Device device = 5;
	public $device;
	public $device_prt = array(2,'class',5,'Device','packed' => false);
	function has_device() {
		if (isset($this->device))	return true;
		return false;
	}
	function clear_device() {
		if (isset($this->device))
			unset($this->device);
	}
	//repeated Impression imp = 8;
	public $imp;
	public $imp_prt = array(3,'class',8,'Impression','packed' => false);
	function size_imp() {
		if (isset($this->imp))	return count($this->imp);
		return 0;
	}
	function imp($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_imp())
			return false;
		$imp = $this->imp;
		return $imp[$index];
	}
	function add_imp($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof Impression) {
			$this->imp[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of Impression";
		return false;
	}
	function clear_imp() {
		if (isset($this->imp))
			unset($this->imp);
	}
	//optional bool is_test = 9 [default = false];
	public $is_test = false;
	public $is_test_prt = array(2,13,9,false,'packed' => false);
	function has_is_test() {
		if (isset($this->is_test))	return true;
		return false;
	}
	function clear_is_test() {
		if (isset($this->is_test))
			unset($this->is_test);
		$this->is_test = false;
	}
	//optional bool is_ping = 10 [default = false];
	public $is_ping = false;
	public $is_ping_prt = array(2,13,10,false,'packed' => false);
	function has_is_ping() {
		if (isset($this->is_ping))	return true;
		return false;
	}
	function clear_is_ping() {
		if (isset($this->is_ping))
			unset($this->is_ping);
		$this->is_ping = false;
	}
}
?>