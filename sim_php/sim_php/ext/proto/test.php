<?php
require_once('const.php');
require_once('BaseClass.php');

class test extends BaseClass {
	//repeated int32 a = 1 [packed = true];
	public $a;
	public $a_prt = array(3,3,1,'packed' => true);
	function size_a() {
		if (isset($this->a))	return count($this->a);
		return 0;
	}
	function a($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_a())
			return false;
		$a = $this->a;
		return $a[$index];
	}
	function add_a($ele) {
		if (isset($ele) && $this->validate_type(3, $ele)) {
			$this->a[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_a() {
		if (isset($this->a))
			unset($this->a);
	}
	//required string b = 2;
	public $b;
	public $b_prt = array(1,14,2,'packed' => false);
	function clear_b() {
		if (isset($this->b))
			unset($this->b);
	}
	//required uint32 c = 3;
	public $c;
	public $c_prt = array(1,5,3,'packed' => false);
	function clear_c() {
		if (isset($this->c))
			unset($this->c);
	}
	//repeated tmp d = 4 [packed = true];
	public $d;
	public $d_prt = array(3,'class',4,'tmp','packed' => true);
	function size_d() {
		if (isset($this->d))	return count($this->d);
		return 0;
	}
	function d($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_d())
			return false;
		$d = $this->d;
		return $d[$index];
	}
	function add_d($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof tmp) {
			$this->d[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of tmp";
		return false;
	}
	function clear_d() {
		if (isset($this->d))
			unset($this->d);
	}
}
class tmp extends BaseClass {
	//repeated float a = 1 [packed = true];
	public $a;
	public $a_prt = array(3,2,1,'packed' => true);
	function size_a() {
		if (isset($this->a))	return count($this->a);
		return 0;
	}
	function a($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_a())
			return false;
		$a = $this->a;
		return $a[$index];
	}
	function add_a($ele) {
		if (isset($ele) && $this->validate_type(2, $ele)) {
			$this->a[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_a() {
		if (isset($this->a))
			unset($this->a);
	}
	//optional uint64 d = 2 [default = 1];
	public $d = 1;
	public $d_prt = array(2,6,2,1,'packed' => false);
	function has_d() {
		if (isset($this->d))	return true;
		return false;
	}
	function clear_d() {
		if (isset($this->d))
			unset($this->d);
		$this->d = 1;
	}
}
?>
