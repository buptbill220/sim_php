<?php
require_once('const.php');
require_once('BaseClass.php');

class Person extends BaseClass {
	//enum 'PhoneType' definition
	const PhoneType_MOBILE = 0;
	const PhoneType_HOME = 1;
	const PhoneType_WORK = 2;
	//required string name = 1;
	public $name;
	public $name_prt = array(1,14,1);
	function clear_name() {
		if (isset($this->name))
			unset($this->name);
	}
	//required int32 id = 2;
	public $id;
	public $id_prt = array(1,3,2);
	function clear_id() {
		if (isset($this->id))
			unset($this->id);
	}
	//optional string email = 3;
	public $email;
	public $email_prt = array(2,14,3);
	function has_email() {
		if (isset($this->email))	return true;
		return false;
	}
	function clear_email() {
		if (isset($this->email))
			unset($this->email);
	}
	//repeated PhoneType pt = 7;
	public $pt;
	public $pt_prt = array(3,'enum',7);
	function size_pt() {
		if (isset($this->pt))	return count($this->pt);
		return 0;
	}
	function pt($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_pt())
			return false;
		$pt = $this->pt;
		return $pt[$index];
	}
	function add_pt($ele) {
		if ($this->validate_type('enum', $ele) && !empty($ele)) {
			$this->pt[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_pt() {
		if (isset($this->pt))
			unset($this->pt);
	}
	//repeated PhoneNumber phone = 4;
	public $phone;
	public $phone_prt = array(3,'class',4);
	function size_phone() {
		if (isset($this->phone))	return count($this->phone);
		return 0;
	}
	function phone($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_phone())
			return false;
		$phone = $this->phone;
		return $phone[$index];
	}
	function add_phone($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof Person_PhoneNumber) {
			$this->phone[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of Person_PhoneNumber";
		return false;
	}
	function clear_phone() {
		if (isset($this->phone))
			unset($this->phone);
	}
	//optional uint32 emaila = 5 [default = 1];
	public $emaila = 1;
	public $emaila_prt = array(2,5,5,1);
	function has_emaila() {
		if (isset($this->emaila))	return true;
		return false;
	}
	function clear_emaila() {
		if (isset($this->emaila))
			unset($this->emaila);
		$this->emaila = 1;
	}
	//repeated PhoneNumber1 phone1 = 6;
	public $phone1;
	public $phone1_prt = array(3,'class',6);
	function size_phone1() {
		if (isset($this->phone1))	return count($this->phone1);
		return 0;
	}
	function phone1($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_phone1())
			return false;
		$phone1 = $this->phone1;
		return $phone1[$index];
	}
	function add_phone1($ele) {
		if (!$this->validate_type('class', $ele) || empty($ele)){
			if (is_object($ele))	$ele = 'object';
			if (is_array($ele))	$ele = 'array';
			echo "add element '$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if ($ele instanceof Person_PhoneNumber1) {
			$this->phone1[] = $ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of Person_PhoneNumber1";
		return false;
	}
	function clear_phone1() {
		if (isset($this->phone1))
			unset($this->phone1);
	}
}
class Person_PhoneNumber extends BaseClass {
	//required string number = 1;
	public $number;
	public $number_prt = array(1,14,1);
	function clear_number() {
		if (isset($this->number))
			unset($this->number);
	}
	//optional PhoneType type = 2 [default = HOME];
	public $type = Person::PhoneType_HOME;
	public $type_prt = array(2,'enum',2,Person::PhoneType_HOME);
	function has_type() {
		if (isset($this->type))	return true;
		return false;
	}
	function clear_type() {
		if (isset($this->type))
			unset($this->type);
		$this->type = Person::PhoneType_HOME;
	}
}
class Person_PhoneNumber_test extends BaseClass {
	//enum 'testenum' definition
	const testenum_A = -4;
	const testenum_B = 2;
	const testenum_C = 3;
	//required string test1 = 1;
	public $test1;
	public $test1_prt = array(1,14,1);
	function clear_test1() {
		if (isset($this->test1))
			unset($this->test1);
	}
	//required uint32 int32 = 2;
	public $int32;
	public $int32_prt = array(1,5,2);
	function clear_int32() {
		if (isset($this->int32))
			unset($this->int32);
	}
	//optional string a = 3;
	public $a;
	public $a_prt = array(2,14,3);
	function has_a() {
		if (isset($this->a))	return true;
		return false;
	}
	function clear_a() {
		if (isset($this->a))
			unset($this->a);
	}
	//repeated string b = 4;
	public $b;
	public $b_prt = array(3,14,4);
	function size_b() {
		if (isset($this->b))	return count($this->b);
		return 0;
	}
	function b($index) {
		if (is_numeric($index) && intval($index) == $index)
			$index = intval($index);
		if (!is_integer($index) || $index < 0 || $index >= $this->size_b())
			return false;
		$b = $this->b;
		return $b[$index];
	}
	function add_b($ele) {
		if ($this->validate_type(14, $ele) && !empty($ele)) {
			$this->b[] = $ele;
			return true;
		}
		if (is_object($ele))	$ele = '[object]';
		if (is_array($ele))	$ele = '[array]';
		echo "add element '$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}
	function clear_b() {
		if (isset($this->b))
			unset($this->b);
	}
	//optional testenum c = 5 [default = A];
	public $c = Person_PhoneNumber_test::testenum_A;
	public $c_prt = array(2,'enum',5,Person_PhoneNumber_test::testenum_A);
	function has_c() {
		if (isset($this->c))	return true;
		return false;
	}
	function clear_c() {
		if (isset($this->c))
			unset($this->c);
		$this->c = Person_PhoneNumber_test::testenum_A;
	}
}
class Person_PhoneNumber1 extends BaseClass {
	//required string aaa = 1;
	public $aaa;
	public $aaa_prt = array(1,14,1);
	function clear_aaa() {
		if (isset($this->aaa))
			unset($this->aaa);
	}
	//optional uint64 bb =2;
	public $bb;
	public $bb_prt = array(2,6,2);
	function has_bb() {
		if (isset($this->bb))	return true;
		return false;
	}
	function clear_bb() {
		if (isset($this->bb))
			unset($this->bb);
	}
}
?>