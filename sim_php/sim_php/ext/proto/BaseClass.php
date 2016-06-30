<?php
/*
discription: the base class which all generated class inherited from.
              including SerializeAsString, SerializeToString, 
              ParseFromStream, ParseFromString, SerializeToStream,
              clear, checkAll public methods.
author: fangming
email: buptbill220@gmail.com
company: alibaba
phone: 15810541016
*/

require_once('const.php');

class BaseClass {
	private $names = array();
	private $names_prt = array();
	function __construct(){
		$ref = new ReflectionClass($this);
		$prts = $ref->getProperties();
		foreach ($prts as $prt) {
			$tmp[$prt->name] = true;
		}
		foreach ($tmp as $key => $value) {
			if (isset($tmp[$key.'_prt'])) {
				$prtname = $key.'_prt';
				$prtvalue = $this->$prtname;
				$this->names[$prtvalue[2]] = $key;
				$this->names_prt[$prtvalue[2]] = $prtname;
			}
		}
	}
	private function formatData($data, $level = 0) {
		if (!isset($data)) {
			$re .= "not set\n";
			return $re;
		}
		$type = gettype($data);
		switch ($type) {
			case 'boolean':$re = $data?"true\n":"false\n";break;
			case 'integer':
			case 'double':$re = "$data\n";break;
			case 'string':$re = "\"$data\"\n";break;
			case 'NULL':$re = "NULL\n";break;
			case 'array':
				$re = "array:\n";
				$tab = str_repeat("\t", $level+1);
				foreach ($data as $dt) {
					$re .= $tab . $this->formatData($dt, $level+1);
				}
				break;
			case 'object':
				$re = str_repeat("\t", $level);
				$re .= $data->DebugString($level+1);break;
			case 'resource':$re = "resource:$data\n";break;
			case 'unknow type':$re = "unknown\n";break;
		}
		return $re;
	}
	function DebugString($level = 0) {
		//if (!$this->checkAll())	return false;
		$pad = str_repeat("\t", $level);
		if (!empty($this->names)) {
			$re = $pad . get_class($this) . ":\n";
			foreach ($this->names as $idx => $name) {
				if (isset($this->$name)) {
					$re .= $pad . "$name: ";
					$re .= $this->formatData($this->$name, $level);
				}
			}
		}
		return $re;
	}
	function SerializeToString(&$str) {
		$re = $this->SerializeAsString();
		$str = $re;
	}
	function SerializeAsString() {
		if (!$this->checkAll())	return false;
		$re = '';
		if (!empty($this->names)) {
			foreach ($this->names as $idx => $name) {
				if (isset($this->$name) && $this->$name !== null) {
					//var_dump(unpack("H*",$re));
					$prt = $this->names_prt[$idx];
					$value = $this->$prt;
					$keystr = $this->keyEncode($value[2], $value[1], $value[0]);
					$valuestr = '';
                    if ($value[0] === REP && $value['packed'] === true) {
                        $prefix = '';
                    } else {
                        $prefix = $keystr;
                    }
					switch ($value[1]) {
						case INT32:case INT64:case 'enum':case BOOL:
						    if ($value[1] === INT32)	{$tail = "0x01"; $fixed = 10;}
						    else {$tail = "0x0f"; $fixed = 10;}
							if ($value[0] === REP) {
								$arr = $this->$name;
								$tmp = '';
							    foreach ($arr as $ele) {
									$tmp .= $prefix . $this->varintEncode($ele, $fixed, $tail);
								}
                                if ($value['packed'] === true){
                                    $valuestr .= $keystr . $this->varintEncode(strlen($tmp));
                                }
                                $valuestr .= $tmp;
							} else {
								$valuestr .= $keystr . $this->varintEncode($this->$name, $fixed, $tail);
							}
							break;
						case UINT32:case UINT64:
							//echo "name: $name, value {$this->$name}\n";
							if ($value[1] === UINT32) {$tail = "\x0f";$fixed = 5;}
							else {$tail = "\x01";$fixed = 10;}
							if ($value[0] === REP) {
								$arr = $this->$name;
								$tmp = '';
								foreach ($arr as $ele) {
									$tmp .= $prefix . $this->varintEncode($ele, $fixed, $tail);
								}
                                if ($value['packed'] === true){
                                    $valuestr .= $keystr . $this->varintEncode(strlen($tmp));
                                }
                                $valuestr .= $tmp;
							} else {
								$valuestr .= $keystr . $this->varintEncode($this->$name, $fixed, $tail);
							}
							break;
						case SINT32:case SINT64:
							//echo "name: $name, value {$this->$name}\n";
							if ($value[0] === REP) {
								$arr = $this->$name;
								$tmp = '';
								foreach ($arr as $ele) {
									$tmp .= $prefix . $this->zigzagEncode($ele);
								}
                                if ($value['packed'] === true){
                                    $tmp .= $prefix . $this->varintEncode(strlen($tmp));
                                }
                                $valuestr .= $tmp;
							} else {
								$valuestr .= $keystr . $this->zigzagEncode($this->$name);
							}
							break;
						case FLOAT:case DOUBLE:
							//echo "name: $name, value {$this->$name}\n";
							if ($value[1] === FLOAT)	$fixed = 4;
							else $fixed = 8;
							if ($value[0] === REP) {
								$arr = $this->$name;
								$tmp = '';
								foreach ($arr as $ele) {
									$tmp .= $prefix . $this->floatEncode($ele, $fixed);
								}
                                if ($value['packed'] === true){
                                    $valuestr .= $keystr . $this->varintEncode(strlen($tmp));
                                }
                                $valuestr .= $tmp;
							} else {
								$valuestr .= $keystr . $this->floatEncode($this->$name, $fixed);
							}
							break;
						case FIXED32:case FIXED64: case SFIXED32:case SFIXED64:
							//echo "name: $name, value {$this->$name}\n";
							if ($value[1] === FIXED32 || $value[1] === SFIXED32)	$fixed = 4;
							else $fixed = 8;
							if ($value[0] === REP) {
								$arr = $this->$name;
								$tmp = '';
								foreach ($arr as $ele) {
									$tmp .= $prefix . $this->fixedEncode($ele, $fixed);
								}
                                if ($value['packed'] === true){
                                    $valuestr .= $keystr . $this->varintEncode(strlen($tmp));
                                }
                                $valuestr .= $tmp;
							} else {
								$valuestr .= $keystr . $this->fixedEncode($this->$name, $fixed);
							}
							break;
						case STRING:case BYTES:
							//echo "name: $name, value {$this->$name}\n";
							if ($value[0] === REP) {
								$arr = $this->$name;
								$tmp = '';
								foreach ($arr as $ele) {
									$tmp .= $prefix . $this->strEncode($ele);
								}
                                if ($value['packed'] === true){
                                    $valuestr .= $keystr . $this->varintEncode(strlen($tmp));
                                }
                                $valuestr .= $tmp;
							} else {
								$valuestr .= $keystr . $this->strEncode($this->$name);
							}
							break;
						case 'class':
							//echo "name: $name, value {$this->$name}\n";
							if ($value[0] === REP) {
								$objs = $this->$name;
								$tmp1 = '';
								foreach ($objs as $obj) {
									$tmp = $obj->SerializeAsString();
									$tmp1 .= $prefix . $this->strEncode($tmp);
								}
                                if ($value['packed'] === true){
                                    $valuestr .= $keystr . $this->varintEncode(strlen($tmp1));
                                }
                                $valuestr .= $tmp1;
							} else {
								$obj = $this->$name;
								$tmp = $obj->SerializeAsString();
								$valuestr .= $keystr . $this->strEncode($tmp);
							}
							break;
						default:
							echo "error: element '$name' has unknow data type\n";
							return false;
					}
					//var_dump(unpack("H*",$keystr));
					$re .= $valuestr;
				}
			}
		}
		return $re;
	}
	function SerializeToStream($filename) {
		$file = fopen($filename, "wb");
		if ($file === false)	return -1;
		$re = $this->SerializeAsString();
		if ($re === false)	return false;
		fwrite($file, $re, strlen($re));
		fclose($file);
		return true;
	}
	function ParseFromString($buffer, $length = -1) {
		if ($buffer == '') {
			echo "buffer is null";
			return false;
		}
		if ($length === -1)	{
			$length = strlen($buffer);
			$this->clear();
		}
		$idx = 0;
		$name_arr = $this->names;
		$prt_arr = $this->names_prt;
		//var_dump(unpack("H*",$buffer));
		while ($idx < $length) {
			$key = $this->varintDecode($buffer, $length, $idx);
			$order = $key >> 3;
			$type = $key & 7;
			if (!isset($name_arr[$order])) {
				echo "unknow field order!\n";
				return false;
			}
			$name = $name_arr[$order];
			$prt = $prt_arr[$order];
			$value = $this->$prt;
			
			if ($this->getFieldType($value[1], $value[0]) !== $type) {
				echo "bin data type dismatch with field type for field '$name'\n";
				return false;
			}
            if ($value[0] === REP && $value['packed'] === true) {
                $ele_len = $this->varintDecode($buffer, $length, $idx);
            } else {
                $ele_len = 1;
            }
			switch ($value[1]) {
				case INT32:case INT64:case 'enum':case BOOL:
					if ($value[1] === INT32)	$fixed = 4;
					else $fixed = 8;
                    for ($i = 0; $i < $ele_len; ) {
                        $ftmpidx = $idx;
					    $decvalue = $this->varintDecode($buffer, $length, $idx, $fixed);
					    if ($decvalue === false)	return false;
					    if ($value[0] === REP) {
						    $func = "add_$name";
						    $this->$func($decvalue);
					    } else $this->$name = $decvalue;
                        $ltmpidx = $idx;
                        $i += $ltmpidx - $ftmpidx;
                    }
					break;
				case UINT32:case UINT64:
					if ($value[1] === UINT32)	$fixed = 4;
					else $fixed = 8;
                    for ($i = 0; $i < $ele_len; ) {
                        $ftmpidx = $idx;
					    $decvalue = $this->varintDecode($buffer, $length, $idx, $fixed);
					    if ($decvalue === false)	return false;
					    if ($value[1] === UINT32)	$decvalue &= 0x7fffffff;
					    else $decvalue &= 0x7fffffffffffffff;
					    if ($value[0] === REP) {
						    $func = "add_$name";
						    $this->$func($decvalue);
					    } else $this->$name = $decvalue;
                        $ltmpidx = $idx;
                        $i += $ltmpidx - $ftmpidx;
                    }
					break;
				case SINT32:case SINT64:
					if ($value[1] === SINT32)	$fixed = 4;
					else $fixed = 8;
                    for ($i = 0; $i < $ele_len; ) {
                        $ftmpidx = $idx;
					    $decvalue = $this->zigzagDecode($buffer, $length, $idx, $fixed);
					    if ($decvalue === false)	return false;
					    if ($value[0] === REP) {
						    $func = "add_$name";
						    $this->$func($decvalue);
					    } else $this->$name = $decvalue;
                        $ltmpidx = $idx;
                        $i += $ltmpidx - $ftmpidx;
                    }
					break;
				case FLOAT:case DOUBLE:
					if ($value[1] === FLOAT)	$fixed = 4;
					else $fixed = 8;
                    for ($i = 0; $i < $ele_len; ) {
                        $ftmpidx = $idx;
					    $decvalue = $this->floatDecode($buffer, $length, $idx, $fixed);
					    if ($decvalue === false)	return false;
					    if ($value[0] === REP) {
						    $func = "add_$name";
						    $this->$func($decvalue);
					    } else $this->$name = $decvalue;
                        $ltmpidx = $idx;
                        $i += $ltmpidx - $ftmpidx;
                    }
					break;
				case FIXED32:case FIXED64:case SFIXED32:case SFIXED64:
					if ($value[1] === FIXED32 || $value[1] === SFIXED32)	$fixed = 4;
					else $fixed = 8;
                    for ($i = 0; $i < $ele_len; ) {
                        $ftmpidx = $idx;
					    $decvalue = $this->fixedDecode($buffer, $length, $idx, $fixed);
					    if ($decvalue === false)	return false;
					    if ($value[0] === REP) {
						    $func = "add_$name";
						    $this->$func($decvalue);
					    } else $this->$name = $decvalue;
                        $ltmpidx = $idx;
                        $i += $ltmpidx - $ftmpidx;
                    }
					break;
				case STRING:case BYTES:
                    for ($i = 0; $i < $ele_len; ) {
                        $ftmpidx = $idx;
					    $decvalue = $this->strDecode($buffer, $length, $idx);
					    if ($decvalue === false)	{echo "eeeeee";return false;}
					    if ($value[0] === REP) {
						    $func = "add_$name";
						    $this->$func($decvalue);
					    } else $this->$name = $decvalue;
                        $ltmpidx = $idx;
                        $i += $ltmpidx - $ftmpidx;
                    }
					break;
				case 'class':
                    for ($i = 0; $i < $ele_len; ) {
                        $ftmpidx = $idx;
					    $decvalue = $this->strDecode($buffer, $length, $idx);
					    if ($decvalue === false)	return false;
					    $tmp = new $value[3];
					    $re = $tmp->ParseFromString($decvalue);
					    if ($re === false)	{echo "error";return false;}
					    if ($value[0] === REP) {
						    $func = "add_$name";
						    $this->$func($tmp);
					    } else $this->$name = $tmp;
                        $ltmpidx = $idx;
                        $i += $ltmpidx - $ftmpidx;
                    }
					break;
				default:
					echo "unknow type\n";
					return false;
			}
		}
		return true;
	}
	function ParseFromStream($filename) {
		$buffer = file_get_contents($filename);
		if ($buffer === false || $buffer == '')	return -1;
		$re = $this->ParseFromString($buffer);
		if ($re === false)	return false;
		return true;
	}
	private function varintDecode(&$buffer, $length, &$idx, $fixed = 4) {
		if ($idx >= $length)	return false;
		$key = 0;
		$shift = 0;
		$begin = $idx;
		while ($idx < $length) {
			$uchar = ord($buffer[$idx]);
			if ($uchar === 255)	{
				if ($idx - $begin > $fixed)	{++$idx;continue;}
				if ($key < 0){
					++$idx;
					++$shift;
					continue;
				}
			}
			if ($uchar & 128) {
				$key |= ($uchar & 127) << ($shift++)*7;
				++$idx;
				continue;
			}
			break;
		}
		if ($key >= 0)	$key |= ($uchar & 127) << ($shift*7);
		++$idx;
		return $key;
	}
	private function fixedDecode(&$buffer, $length, &$idx, $fixed = 4) {
		if ($idx + $fixed > $length)	return false;
		$str = substr($buffer, $idx, $fixed);
		if ($fixed == 4) {
			$re = unpack("I", $value);
		} else {
			$re = unpack("V", $value);
		}
		$idx += $fixed;
		if (!empty($re))	return $re[1];
		return false;
	}
	private function floatDecode(&$buffer, $length, &$idx, $fixed = 4) {
		if ($idx + $fixed > $length)	return false;
		$str = substr($buffer, $idx, $fixed);
		if ($fixed ==4) {
			$re = unpack("f", $str);
		} else {
			$re = unpack("d", $str);
		}
		$idx += $fixed;
		if (!empty($re))	return $re[1];
		return false;
	}
	private function zigzagDecode(&$buffer, $length, &$idx, $fixed = 4) {
		$decvalue = $this->varintDecode($buffer, $length, $idx, $fixed);
		if ($decvalue === false)	return false;
		if ($fixed == 4)	$decode = ($decvalue >> 1) ^ (($decvalue << 31) >> 31);
		else $decode = ($decvalue >> 1) ^ (($decvalue << 63) >> 63);
		return $decode;
	}
	private function strDecode(&$buffer, $length, &$idx) {
		$size = $this->varintDecode($buffer, $length, $idx);
		if ($size === false)	return false;
		if ($idx + $size > $length)	return false;
		$str = substr($buffer, $idx, $size);
		if ($str === false)	$str = '';
		$idx += $size;
		return $str;
	}
	private function checkAll() {
		if (!empty($this->names)) {
			foreach ($this->names as $idx => $name) {
				$prt = &$this->names_prt[$idx];
				$value = &$this->$prt;
				if (isset($this->$name) && $value[0] === OPT) {
					if ($value[1] === 'class' && ($this->$name instanceof $vaule[4])) {
						$obj = $this->$name;
						if (!$obj->checkAll())	return false;
						continue;
					}
					if ($this->validate_type($value[1], $this->$name))	continue;
					echo "element " . $name . " has wrong type\n";
					return false;
				}
				else if (isset($this->$name) && $value[0] === REP) {
					if (is_array($this->$name)) {
						$arr = $this->$name;
						$ele = $arr[0];
						if ($value[1] === 'class' && ($ele instanceof $value[3])) {
							$objs = $this->$name;
							foreach ($objs as $obj)	if (!$obj->checkAll())	return false;
							continue;
						}
						if ($this->validate_type($value[1], $ele))	continue;
						echo "element " . $name . " has wrong type\n";
						return false;
					}
					echo "element " . $name . " must be array\n";
					return false;
				}
				else if (isset($this->$name) && $value[0] === REQ) {
					if ($value[1] === 'class' && ($this->$name instanceof $vaule[4])) {
						$obj = $this->$name;
						if (!$obj->checkAll())	return false;
						continue;
					}
					if ($this->validate_type($value[1], $this->$name))	continue;
					echo "element " . $name . " has wrong type\n";
					return false;
				}
				if ($value[0] === OPT || $value[0] === REP)	continue;
				echo "element " . $name . " is required type, must set a value\n";
				return false;
			}
		}
		return true;
	}
	function clear(){
		if (!empty($this->names)) {
			foreach ($this->names as $idx => $name) {
				if (isset($this->$name)) {
					$prt = &$this->names_prt[$idx];
					$value = &$this->$prt;
					if (isset($value[3])) {
						$this->$name = $value[3];
					}else {
						unset($this->$name);
					}
				}
			}
		}
	}
	protected function validate_type($type, &$ele) {
		$etype = gettype($ele);
		$re = false;
		switch ($type) {
			case FLOAT:
			case DOUBLE:
				if (is_numeric($ele))	$re = true;
				break;
			case INT32:case INT64:case UINT32:case UINT64:
			case SINT32:case SINT64:case FIXED32:case FIXED64:
			case SFIXED32:case SFIXED64:
				if (is_numeric($ele) || intval($ele) == $ele)	$re = true;
				break;
			case BOOL:
				if (is_bool($ele) )	$re = true;
				elseif ($ele == 'true' || $ele == 'false') {
					$ele = ($ele == 'true')?true:false;
					$re = true;
				}
				break;
			case STRING:
				if (is_string($ele))	$re = true;
				break;
			case BYTES:
				if (is_string($ele))	$re = true;
				break;
			case 'class':
				if (is_object($ele))	$re = true;
				break;
			case 'enum':
				if (is_numeric($ele))	$re = true;
				break;
		}
		return $re;
	}
	//compatible with fixed bytes type
	private function varintEncode($value, $fixed = 10, $tail = "\x01") {
		if (!is_integer($value))	$value = intval($value);
		$re = '';
		$count = 0;
		$a = $value;
		$b = $a >> 7;
		$c = $a & 127;
		while ($a !== $b) {
			++$count;
			$a = $b;
			$b = $a >> 7;
			if ($a !== $b || $value < 0)	$re .= pack("C*", $c | 128);
			else $re .= pack("C*", $c);
			$c = $a & 127;
		}
		if ($value < 0) {
			while (++$count <= $fixed-1)	$re .= "\xff";
			$re .= $tail;
		}
		if ($re === '')	$re = "\x00";
		return $re;
	}
	//use pack function fixed encode
	private function fixedEncode($value, $fixed = 4) {
		if ($fixed == 4) {
			$re = pack("I", $value);
		} else {
			$re = pack("V", $value);
		}
		return $re;
	}
	//my fixed encode
	private function myfixedEncode($value, $fixed = 4) {
		$re = '';
		$count = 0;
		$a = $value;
		$b = $a >> 8;
		$c = $a & 255;
		while ($a !== $b) {
			++$count;
			$re .= pack("C*", $c);
			$a = $b;
			$b = $a >> 8;
			$c = $a & 255;
		}
		if ($value < 0)	$pad = "\xff";
		else $pad = "\x00";
		while (++$count <= $fixed)	$re .= $pad;
		if ($re === '')	$re = "\x00";
		return $re;
	}
	//ZigZag encode
	private function zigzagEncode($value, $fixed = 4) {
		if (!is_integer($value))	$value = intval($value);
		if ($fixed === 4)	$format = ($value << 1) ^ ($value >> 31);
		else $format = ($value << 1) ^ ($value >> 63);
		if ($format < 0)	{
			echo "over flow 32bits!\n";
			return false;
		}
		return $this->varintEncode($format);
	}
	//compatible width string,bytes,message
	private function strEncode($value) {
		$length= strlen($value);
		$re = $this->varintEncode($length);
		$re .= $value;
		return $re;
	}
	//float,double encode
	private function floatEncode($value, $fixed = 4) {
		if ($fixed ==4) {
			$re = pack("f", $value);
		} else {
			$re = pack("d", $value);
		}
		return $re;
	}
	//generate key encode
	private function keyEncode($order, $type, $pre = OPT) {
		//if ($pre === REP)	$t = 2;
		$t = $this->getFieldType($type, $pre);
		if ($t !== -1) {
			$value = ($order << 3) | $t; 
			return $this->varintEncode($value);
		}
		return false;
	}
	private function getFieldType($type, $pre = OPT) {
		switch ($type) {
			case INT32:case INT64:case UINT32:case UINT64:
			case SINT32:case SINT64:case BOOL:case 'enum':
				$t = 0;break;
			case FIXED64:case SFIXED64:case DOUBLE:
				$t = 1;break;
			case STRING:case BYTES:case 'class':
				$t = 2;break;
			case 'groups':
				$t = 3;break;
			case 'groupe':
				$t = 4;break;
			case FIXED32:case SFIXED32:case FLOAT:
				$t = 5;break;
			default:
				echo "unknow type!\n";
				$t = -1;break;
		}
		return $t;
	}
}
