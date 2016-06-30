<?php
require_once('const.php');
require_once('BaseClass.php');

class BidRequest extends BaseClass {
	//required int32 version = 1;
	public $version;
	public $version_prt = array(1,3,1,'packed' => false);
	function clear_version() {
		if (isset($this->version))
			unset($this->version);
	}
	//required string bid = 2;
	public $bid;
	public $bid_prt = array(1,14,2,'packed' => false);
	function clear_bid() {
		if (isset($this->bid))
			unset($this->bid);
	}
	//optional uint32 is_test = 11 [default = 0];
	public $is_test = 0;
	public $is_test_prt = array(2,5,11,0,'packed' => false);
	function has_is_test() {
		if (isset($this->is_test))	return true;
		return false;
	}
	function clear_is_test() {
		if (isset($this->is_test))
			unset($this->is_test);
		$this->is_test = 0;
	}
	//optional uint32 is_ping = 12 [default = 0];
	public $is_ping = 0;
	public $is_ping_prt = array(2,5,12,0,'packed' => false);
	function has_is_ping() {
		if (isset($this->is_ping))	return true;
		return false;
	}
	function clear_is_ping() {
		if (isset($this->is_ping))
			unset($this->is_ping);
		$this->is_ping = 0;
	}
	//optional string tid = 3;
	public $tid;
	public $tid_prt = array(2,14,3,'packed' => false);
	function has_tid() {
		if (isset($this->tid))	return true;
		return false;
	}
	function clear_tid() {
		if (isset($this->tid))
			unset($this->tid);
	}
	//optional string ip = 4;
	public $ip;
	public $ip_prt = array(2,14,4,'packed' => false);
	function has_ip() {
		if (isset($this->ip))	return true;
		return false;
	}
	function clear_ip() {
		if (isset($this->ip))
			unset($this->ip);
	}
	//optional string user_agent = 5;
	public $user_agent;
	public $user_agent_prt = array(2,14,5,'packed' => false);
	function has_user_agent() {
		if (isset($this->user_agent))	return true;
		return false;
	}
	function clear_user_agent() {
		if (isset($this->user_agent))
			unset($this->user_agent);
	}
	//optional int32 timezone_offset = 13;
	public $timezone_offset;
	public $timezone_offset_prt = array(2,3,13,'packed' => false);
	function has_timezone_offset() {
		if (isset($this->timezone_offset))	return true;
		return false;
	}
	function clear_timezone_offset() {
		if (isset($this->timezone_offset))
			unset($this->timezone_offset);
	}
	//repeated int32 user_vertical = 14;
	public $user_vertical;
	public $user_vertical_prt = array(3,3,14,'packed' => false);
	function size_user_vertical() {
		if (isset($this->user_vertical))	return count($this->user_vertical);
		return 0;
	}
	function user_vertical($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_user_vertical())
			return false;
		$user_vertical = $this->user_vertical;
		return $user_vertical[$index];
	}
	function add_user_vertical($ele) {
		if (isset($ele) && $this->validate_type(3, $ele)) {
			$this->user_vertical[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_user_vertical() {
		if (isset($this->user_vertical))
			unset($this->user_vertical);
	}
	//optional uint32 tid_version = 19;
	public $tid_version;
	public $tid_version_prt = array(2,5,19,'packed' => false);
	function has_tid_version() {
		if (isset($this->tid_version))	return true;
		return false;
	}
	function clear_tid_version() {
		if (isset($this->tid_version))
			unset($this->tid_version);
	}
	//repeated string excluded_click_through_url = 6;
	public $excluded_click_through_url;
	public $excluded_click_through_url_prt = array(3,14,6,'packed' => false);
	function size_excluded_click_through_url() {
		if (isset($this->excluded_click_through_url))	return count($this->excluded_click_through_url);
		return 0;
	}
	function excluded_click_through_url($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_excluded_click_through_url())
			return false;
		$excluded_click_through_url = $this->excluded_click_through_url;
		return $excluded_click_through_url[$index];
	}
	function add_excluded_click_through_url($ele) {
		if (isset($ele) && $this->validate_type(14, $ele)) {
			$this->excluded_click_through_url[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_excluded_click_through_url() {
		if (isset($this->excluded_click_through_url))
			unset($this->excluded_click_through_url);
	}
	//optional string url = 7;
	public $url;
	public $url_prt = array(2,14,7,'packed' => false);
	function has_url() {
		if (isset($this->url))	return true;
		return false;
	}
	function clear_url() {
		if (isset($this->url))
			unset($this->url);
	}
	//optional uint32 category = 8;
	public $category;
	public $category_prt = array(2,5,8,'packed' => false);
	function has_category() {
		if (isset($this->category))	return true;
		return false;
	}
	function clear_category() {
		if (isset($this->category))
			unset($this->category);
	}
	//optional uint32 adx_type = 9 [default = 0];
	public $adx_type = 0;
	public $adx_type_prt = array(2,5,9,0,'packed' => false);
	function has_adx_type() {
		if (isset($this->adx_type))	return true;
		return false;
	}
	function clear_adx_type() {
		if (isset($this->adx_type))
			unset($this->adx_type);
		$this->adx_type = 0;
	}
	//optional string anonymous_id = 15;
	public $anonymous_id;
	public $anonymous_id_prt = array(2,14,15,'packed' => false);
	function has_anonymous_id() {
		if (isset($this->anonymous_id))	return true;
		return false;
	}
	function clear_anonymous_id() {
		if (isset($this->anonymous_id))
			unset($this->anonymous_id);
	}
	//optional string detected_language = 16;
	public $detected_language;
	public $detected_language_prt = array(2,14,16,'packed' => false);
	function has_detected_language() {
		if (isset($this->detected_language))	return true;
		return false;
	}
	function clear_detected_language() {
		if (isset($this->detected_language))
			unset($this->detected_language);
	}
	//optional int32 category_version = 18;
	public $category_version;
	public $category_version_prt = array(2,3,18,'packed' => false);
	function has_category_version() {
		if (isset($this->category_version))	return true;
		return false;
	}
	function clear_category_version() {
		if (isset($this->category_version))
			unset($this->category_version);
	}
	//repeated AdzInfo adzinfo = 10;
	public $adzinfo;
	public $adzinfo_prt = array(3,'class',10,'BidRequest_AdzInfo','packed' => false);
	function size_adzinfo() {
		if (isset($this->adzinfo))	return count($this->adzinfo);
		return 0;
	}
	function adzinfo($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_adzinfo())
			return false;
		$adzinfo = $this->adzinfo;
		return $adzinfo[$index];
	}
	function add_adzinfo($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof BidRequest_AdzInfo) {
			$this->adzinfo[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of BidRequest_AdzInfo";
		return false;
	}
	function clear_adzinfo() {
		if (isset($this->adzinfo))
			unset($this->adzinfo);
	}
	//repeated int32 excluded_sensitive_category = 17;
	public $excluded_sensitive_category;
	public $excluded_sensitive_category_prt = array(3,3,17,'packed' => false);
	function size_excluded_sensitive_category() {
		if (isset($this->excluded_sensitive_category))	return count($this->excluded_sensitive_category);
		return 0;
	}
	function excluded_sensitive_category($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_excluded_sensitive_category())
			return false;
		$excluded_sensitive_category = $this->excluded_sensitive_category;
		return $excluded_sensitive_category[$index];
	}
	function add_excluded_sensitive_category($ele) {
		if (isset($ele) && $this->validate_type(3, $ele)) {
			$this->excluded_sensitive_category[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_excluded_sensitive_category() {
		if (isset($this->excluded_sensitive_category))
			unset($this->excluded_sensitive_category);
	}
	//repeated int32 excluded_ad_category = 20;
	public $excluded_ad_category;
	public $excluded_ad_category_prt = array(3,3,20,'packed' => false);
	function size_excluded_ad_category() {
		if (isset($this->excluded_ad_category))	return count($this->excluded_ad_category);
		return 0;
	}
	function excluded_ad_category($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_excluded_ad_category())
			return false;
		$excluded_ad_category = $this->excluded_ad_category;
		return $excluded_ad_category[$index];
	}
	function add_excluded_ad_category($ele) {
		if (isset($ele) && $this->validate_type(3, $ele)) {
			$this->excluded_ad_category[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_excluded_ad_category() {
		if (isset($this->excluded_ad_category))
			unset($this->excluded_ad_category);
	}
}
class BidRequest_AdzInfo extends BaseClass {
	//enum 'Location' definition
	const Location_NA = 0;
	const Location_FIRST_VIEW = 1;
	const Location_OTHER_VIEW = 2;
	//enum 'ViewScreen' definition
	const ViewScreen_SCREEN_NA = 0;
	const ViewScreen_SCREEN_FIRST = 1;
	const ViewScreen_SCREEN_SECOND = 2;
	const ViewScreen_SCREEN_THIRD = 3;
	const ViewScreen_SCREEN_FOURTH = 4;
	const ViewScreen_SCREEN_FIFTH = 5;
	const ViewScreen_SCREEN_OTHER = 6;
	//required uint32 id = 1;
	public $id;
	public $id_prt = array(1,5,1,'packed' => false);
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//required string pid = 2;
	public $pid;
	public $pid_prt = array(1,14,2,'packed' => false);
	function clear_pid() {
		if (isset($this->pid))
			unset($this->pid);
	}
	//optional string size = 3;
	public $size;
	public $size_prt = array(2,14,3,'packed' => false);
	function has_size() {
		if (isset($this->size))	return true;
		return false;
	}
	function clear_size() {
		if (isset($this->size))
			unset($this->size);
	}
	//optional uint32 ad_bid_count = 4 [default = 2];
	public $ad_bid_count = 2;
	public $ad_bid_count_prt = array(2,5,4,2,'packed' => false);
	function has_ad_bid_count() {
		if (isset($this->ad_bid_count))	return true;
		return false;
	}
	function clear_ad_bid_count() {
		if (isset($this->ad_bid_count))
			unset($this->ad_bid_count);
		$this->ad_bid_count = 2;
	}
	//repeated uint32 view_type = 5;
	public $view_type;
	public $view_type_prt = array(3,5,5,'packed' => false);
	function size_view_type() {
		if (isset($this->view_type))	return count($this->view_type);
		return 0;
	}
	function view_type($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_view_type())
			return false;
		$view_type = $this->view_type;
		return $view_type[$index];
	}
	function add_view_type($ele) {
		if (isset($ele) && $this->validate_type(5, $ele)) {
			$this->view_type[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_view_type() {
		if (isset($this->view_type))
			unset($this->view_type);
	}
	//repeated uint32 excluded_filter = 6;
	public $excluded_filter;
	public $excluded_filter_prt = array(3,5,6,'packed' => false);
	function size_excluded_filter() {
		if (isset($this->excluded_filter))	return count($this->excluded_filter);
		return 0;
	}
	function excluded_filter($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_excluded_filter())
			return false;
		$excluded_filter = $this->excluded_filter;
		return $excluded_filter[$index];
	}
	function add_excluded_filter($ele) {
		if (isset($ele) && $this->validate_type(5, $ele)) {
			$this->excluded_filter[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_excluded_filter() {
		if (isset($this->excluded_filter))
			unset($this->excluded_filter);
	}
	//optional uint32 min_cpm_price = 7;
	public $min_cpm_price;
	public $min_cpm_price_prt = array(2,5,7,'packed' => false);
	function has_min_cpm_price() {
		if (isset($this->min_cpm_price))	return true;
		return false;
	}
	function clear_min_cpm_price() {
		if (isset($this->min_cpm_price))
			unset($this->min_cpm_price);
	}
	//optional Location adz_location = 8 [default = NA];
	public $adz_location = BidRequest_AdzInfo::Location_NA;
	public $adz_location_prt = array(2,'enum',8,BidRequest_AdzInfo::Location_NA,'packed' => false);
	function has_adz_location() {
		if (isset($this->adz_location))	return true;
		return false;
	}
	function clear_adz_location() {
		if (isset($this->adz_location))
			unset($this->adz_location);
		$this->adz_location = BidRequest_AdzInfo::Location_NA;
	}
	//optional ViewScreen view_screen = 9 [default = SCREEN_NA];
	public $view_screen = BidRequest_AdzInfo::ViewScreen_SCREEN_NA;
	public $view_screen_prt = array(2,'enum',9,BidRequest_AdzInfo::ViewScreen_SCREEN_NA,'packed' => false);
	function has_view_screen() {
		if (isset($this->view_screen))	return true;
		return false;
	}
	function clear_view_screen() {
		if (isset($this->view_screen))
			unset($this->view_screen);
		$this->view_screen = BidRequest_AdzInfo::ViewScreen_SCREEN_NA;
	}
}
class BidResponse extends BaseClass {
	//required int32 version = 1;
	public $version;
	public $version_prt = array(1,3,1,'packed' => false);
	function clear_version() {
		if (isset($this->version))
			unset($this->version);
	}
	//required string bid = 2;
	public $bid;
	public $bid_prt = array(1,14,2,'packed' => false);
	function clear_bid() {
		if (isset($this->bid))
			unset($this->bid);
	}
	//repeated Ads ads = 3;
	public $ads;
	public $ads_prt = array(3,'class',3,'BidResponse_Ads','packed' => false);
	function size_ads() {
		if (isset($this->ads))	return count($this->ads);
		return 0;
	}
	function ads($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_ads())
			return false;
		$ads = $this->ads;
		return $ads[$index];
	}
	function add_ads($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof BidResponse_Ads) {
			$this->ads[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of BidResponse_Ads";
		return false;
	}
	function clear_ads() {
		if (isset($this->ads))
			unset($this->ads);
	}
}
class BidResponse_Ads extends BaseClass {
	//required uint32 adzinfo_id = 1;
	public $adzinfo_id;
	public $adzinfo_id_prt = array(1,5,1,'packed' => false);
	function clear_adzinfo_id() {
		if (isset($this->adzinfo_id))
			unset($this->adzinfo_id);
	}
	//required uint32 max_cpm_price = 2;
	public $max_cpm_price;
	public $max_cpm_price_prt = array(1,5,2,'packed' => false);
	function clear_max_cpm_price() {
		if (isset($this->max_cpm_price))
			unset($this->max_cpm_price);
	}
	//optional uint32 ad_bid_count_idx = 3;
	public $ad_bid_count_idx;
	public $ad_bid_count_idx_prt = array(2,5,3,'packed' => false);
	function has_ad_bid_count_idx() {
		if (isset($this->ad_bid_count_idx))	return true;
		return false;
	}
	function clear_ad_bid_count_idx() {
		if (isset($this->ad_bid_count_idx))
			unset($this->ad_bid_count_idx);
	}
	//optional string html_snippet = 4;
	public $html_snippet;
	public $html_snippet_prt = array(2,14,4,'packed' => false);
	function has_html_snippet() {
		if (isset($this->html_snippet))	return true;
		return false;
	}
	function clear_html_snippet() {
		if (isset($this->html_snippet))
			unset($this->html_snippet);
	}
	//repeated string click_through_url = 5;
	public $click_through_url;
	public $click_through_url_prt = array(3,14,5,'packed' => false);
	function size_click_through_url() {
		if (isset($this->click_through_url))	return count($this->click_through_url);
		return 0;
	}
	function click_through_url($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_click_through_url())
			return false;
		$click_through_url = $this->click_through_url;
		return $click_through_url[$index];
	}
	function add_click_through_url($ele) {
		if (isset($ele) && $this->validate_type(14, $ele)) {
			$this->click_through_url[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_click_through_url() {
		if (isset($this->click_through_url))
			unset($this->click_through_url);
	}
	//repeated int32 category = 6;
	public $category;
	public $category_prt = array(3,3,6,'packed' => false);
	function size_category() {
		if (isset($this->category))	return count($this->category);
		return 0;
	}
	function category($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_category())
			return false;
		$category = $this->category;
		return $category[$index];
	}
	function add_category($ele) {
		if (isset($ele) && $this->validate_type(3, $ele)) {
			$this->category[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_category() {
		if (isset($this->category))
			unset($this->category);
	}
	//repeated int32 creative_type = 7;
	public $creative_type;
	public $creative_type_prt = array(3,3,7,'packed' => false);
	function size_creative_type() {
		if (isset($this->creative_type))	return count($this->creative_type);
		return 0;
	}
	function creative_type($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_creative_type())
			return false;
		$creative_type = $this->creative_type;
		return $creative_type[$index];
	}
	function add_creative_type($ele) {
		if (isset($ele) && $this->validate_type(3, $ele)) {
			$this->creative_type[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_creative_type() {
		if (isset($this->creative_type))
			unset($this->creative_type);
	}
	//optional string network_guid = 8;
	public $network_guid;
	public $network_guid_prt = array(2,14,8,'packed' => false);
	function has_network_guid() {
		if (isset($this->network_guid))	return true;
		return false;
	}
	function clear_network_guid() {
		if (isset($this->network_guid))
			unset($this->network_guid);
	}
	//optional string extend_data = 9;
	public $extend_data;
	public $extend_data_prt = array(2,14,9,'packed' => false);
	function has_extend_data() {
		if (isset($this->extend_data))	return true;
		return false;
	}
	function clear_extend_data() {
		if (isset($this->extend_data))
			unset($this->extend_data);
	}
	//repeated string destination_url = 10;
	public $destination_url;
	public $destination_url_prt = array(3,14,10,'packed' => false);
	function size_destination_url() {
		if (isset($this->destination_url))	return count($this->destination_url);
		return 0;
	}
	function destination_url($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_destination_url())
			return false;
		$destination_url = $this->destination_url;
		return $destination_url[$index];
	}
	function add_destination_url($ele) {
		if (isset($ele) && $this->validate_type(14, $ele)) {
			$this->destination_url[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_destination_url() {
		if (isset($this->destination_url))
			unset($this->destination_url);
	}
	//optional string creative_id = 11;
	public $creative_id;
	public $creative_id_prt = array(2,14,11,'packed' => false);
	function has_creative_id() {
		if (isset($this->creative_id))	return true;
		return false;
	}
	function clear_creative_id() {
		if (isset($this->creative_id))
			unset($this->creative_id);
	}
}
class BidResult extends BaseClass {
	//required int32 version = 1;
	public $version;
	public $version_prt = array(1,3,1,'packed' => false);
	function clear_version() {
		if (isset($this->version))
			unset($this->version);
	}
	//required string bid = 2;
	public $bid;
	public $bid_prt = array(1,14,2,'packed' => false);
	function clear_bid() {
		if (isset($this->bid))
			unset($this->bid);
	}
	//repeated Res res = 3;
	public $res;
	public $res_prt = array(3,'class',3,'BidResult_Res','packed' => false);
	function size_res() {
		if (isset($this->res))	return count($this->res);
		return 0;
	}
	function res($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_res())
			return false;
		$res = $this->res;
		return $res[$index];
	}
	function add_res($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof BidResult_Res) {
			$this->res[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of BidResult_Res";
		return false;
	}
	function clear_res() {
		if (isset($this->res))
			unset($this->res);
	}
}
class BidResult_Res extends BaseClass {
	//required uint32 adzinfo_id = 1;
	public $adzinfo_id;
	public $adzinfo_id_prt = array(1,5,1,'packed' => false);
	function clear_adzinfo_id() {
		if (isset($this->adzinfo_id))
			unset($this->adzinfo_id);
	}
	//optional uint32 ad_bid_count_idx = 2;
	public $ad_bid_count_idx;
	public $ad_bid_count_idx_prt = array(2,5,2,'packed' => false);
	function has_ad_bid_count_idx() {
		if (isset($this->ad_bid_count_idx))	return true;
		return false;
	}
	function clear_ad_bid_count_idx() {
		if (isset($this->ad_bid_count_idx))
			unset($this->ad_bid_count_idx);
	}
	//optional int32 result_code = 3 [default = 0];
	public $result_code = 0;
	public $result_code_prt = array(2,3,3,0,'packed' => false);
	function has_result_code() {
		if (isset($this->result_code))	return true;
		return false;
	}
	function clear_result_code() {
		if (isset($this->result_code))
			unset($this->result_code);
		$this->result_code = 0;
	}
	//optional uint32 result_price = 4;
	public $result_price;
	public $result_price_prt = array(2,5,4,'packed' => false);
	function has_result_price() {
		if (isset($this->result_price))	return true;
		return false;
	}
	function clear_result_price() {
		if (isset($this->result_price))
			unset($this->result_price);
	}
	//optional string extend_data = 5;
	public $extend_data;
	public $extend_data_prt = array(2,14,5,'packed' => false);
	function has_extend_data() {
		if (isset($this->extend_data))	return true;
		return false;
	}
	function clear_extend_data() {
		if (isset($this->extend_data))
			unset($this->extend_data);
	}
}
?>