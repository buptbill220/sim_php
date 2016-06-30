<?php
class TestCase extends Base {
	protected $name		= 'test';
	protected $flag		= false;
	protected $msg		= '';
	protected $expect	= null;
	protected $actual	= null;
	protected $dom		= null;
	//兼容原来的
	protected $caseName	= null;
	protected $caseType	= null;
	protected $caseData	= null;
	//新增
	protected $others	= null;
	protected $datatype	= 'string';
	
	function __construct($casename = 'test') {
		if (empty($casename)) {
			$this->name = 'test';
		} else {
			$this->name = $casename;
		}
	}
	
	function run(){
		INFO::setInfo('run case:<' . $this->casename . '> ' . 
					  'casename:<' . $this->caseName . '> start...');
	}
	abstract function start() {}
	
}