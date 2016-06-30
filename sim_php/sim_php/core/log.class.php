<?php
class Log extends Base {
	//output mode
	const STDERR    = 0;
	const FILE      = 1;
	
	//message write mode
	const DEBUG     = 0;
	const NOTICE    = 1;
	const INFO      = 2;
	const WARN      = 3;
	const ERROR     = 4;
	
	static $mode    = null;
	static $file    = null;
	static $fp      = null;
	static $level   = null;
	
	private function __construct() {}
	
	public static function iniFile($mode = self::STDERR, $case = null) {
		switch ($mode) {
			case self::STDERR:
				self::$mode = self::STDERR;
				self::$file = 'php://stderr';
				//or fwrite(STDERR, 'test');
				break;
			default:
				self::$mode = self::FILE;
				if (empty($case)) {
					throw new Errorexp('log ' . $case . ' is null');
				}
				$filename = 'log_' . $case . '.xml_' . date(Conf::T_FUL) . 
							'_' . getCurUser();
				$file = HOME_DIR . Conf::P_L_LOGS . $filename;
				echo $file;
				self::$file = $file;
				break;
		}
		self::$fp = fopen(self::$file, 'w');
		if (null === self::$fp) {
			throw new Errorexp('open file ' . self::$file . ' error');
		
		}
		if (defined('LOGTYPE')) {
			self::$level = LOGTYPE;
			return ;
		}
		self::$level = self::ERROR;
	}
	
	public function logErr($logType = self::ERROR, $msg) {
		if (null === self::$fp) return false;
		if ($logType < self::$level)	return ;
		switch ($logType) {
			case self::ERROR:
				$line = '[ERROR] ';
				break;
			case self::DEBUG:
				$line = '[DEBUG] ';
				break;
			case self::WARN:
				$line = '[WARNN] ';
				break;
			case self::NOTICE:
				$line = '[NOTIC] ';
				break;
			case self::INFO:
				$line = '[INFOM] ';
				break;
			default:
				$line = '[UNKNO] ';
		}
		
		$time = date(CONF::T_DAY);
		$line .= $time . ' ';
		$line .= $msg . "\n";
		
		fwrite(self::$fp, $line);
		return true;
	}
	
	public static function close() {	
		if (null !== null) {
			fclose(self::$fp);
			return true;
		}
		return false;
	}
}