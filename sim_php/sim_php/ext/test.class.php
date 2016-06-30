<?php
class test extends Base {
    static function test_log($case) {
        
        Log::iniFile(Log::STDERR, $case);
        Log::logErr(Log::ERROR, "error test");
        Log::logErr(Log::WARN, "warning test");
        Log::logErr(Log::DEBUG, "debug test");
        Log::logErr(Log::NOTICE, "notice test");
        Log::logErr(Log::INFO, "info test");
        Log::close();
    }
	static function test_cache() {
		$cache = Cache::getInstance();
		$cache->init();
		$cache->set("test", array("123", "ddsfd"));
		dump($cache->get("test"));
	}
	static function test_template() {
	    $tmp = new Template(dirname(__FILE__) . "/");
		$tmp->assign("aaa", "test-template-aaa");
		$tmp->assign("ddd", array("test1", "test2"));
	    $tmp->display("aaa.php");
	}
}
