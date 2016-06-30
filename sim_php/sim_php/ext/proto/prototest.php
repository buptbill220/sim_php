<?php
require_once('tanx-bidding.php');
require_once('Person.php');
$bid = new BidRequest;
$bid->version = 3;
$bid->bid = md5(mt_rand());
$bid->is_test = 0;
$bid->is_ping = 1;
$bid->tid = '' . mt_rand() . '';
$bid->ip = "127.0.0.1";
$bid->user_agent = "Fixfox";
$bid->timezone_offset = 60*8;
$bid->add_user_vertical(1);
$bid->add_user_vertical(2);
$bid->add_user_vertical(3);
$bid->tid_version = 22;
$bid->add_excluded_click_through_url("baidu.com");
$bid->add_excluded_click_through_url("google.com");
$bid->url = "http://55j1.com";
$bid->category = 50009;
//$bid->adx_type = 10;
//$bid->anonymous_id = 1;
$bid->detected_language = "en";
$bid->category_version = 19;
for ($i = 0; $i <= 0; ++$i) {
    $adzinfo = new BidRequest_AdzInfo;
	$adzinfo->id = $i;
	$adzinfo->pid = "mm_123455678_8765432_00000000$i";
	$adzinfo->size = "250x300";
	$adzinfo->ad_bid_count = 1;
	$adzinfo->add_view_type($i+10);
	$adzinfo->add_view_type($i+11);
	$adzinfo->add_excluded_filter(1000+$i);
	$adzinfo->min_cpm_price = 100+$i;
	$adzinfo->adz_location = BidRequest_AdzInfo::Location_OTHER_VIEW;
	$adzinfo->view_screen = BidRequest_AdzInfo::ViewScreen_SCREEN_SECOND;
	$bid->add_adzinfo($adzinfo);
}
$bid->add_adzinfo($bid);
$bid->add_excluded_sensitive_category(11111);
$bid->add_excluded_ad_category(222222);
echo "\nall\n";
echo $echo1 = $bid->DebugString();
$str = $bid->SerializeAsString();
var_dump(unpack("H*",$bid->SerializeAsString()));

echo "parse from bid:----------------------------------------------------------------------------------------\n";
$bid1 = new BidRequest;
$bid1->ParseFromString($str);
echo $echo2 = $bid1->DebugString();
if ($echo1 == $echo2) {
    echo "ok\n";
}
//$bid->clear_adzinfo();
//echo "\nclear adzinfo\n";
//echo $bid->DebugString();
//$bid->clear();
//echo "\nclear all\n";
require_once('test.php');

$t = new test;
$t->add_a(1);
$t->add_a(2);
$t->add_a(100000);
$t->add_a(-33333);
$t->b = "teststring";
$t->c = 56623;

for ($i = 0; $i < 3; ++$i) {
    $tmp = new tmp;
    $tmp->add_a(13.33);
    $tmp->add_a(-10);
    $tmp->d = 998;
    $t->add_d($tmp);
}

echo $teststr = $t->DebugString();
$str = $t->SerializeAsString();
var_dump(unpack("H*",$t->SerializeAsString()));
echo "parse test--------------------------------------","\n";

$tt = new test;
$tt->ParseFromString($str);
echo $teststr1 = $t->DebugString();

if ($teststr == $teststr1) {
    echo "ok\n";
}
?>
