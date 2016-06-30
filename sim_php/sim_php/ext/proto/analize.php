<?php
require_once('const.php');
require_once('preg.php');
require_once('normalization.php');
require_once('handle.php');

function analize($input_name)
{
	$file_input = fopen($input_name, 'r');
	if( $file_input !== false ){
		$i = 0;
		$cur_idx = -1;
		$parent_idx = -1;
		$max_idx = -1;
		$stat_idx = -1;
		$tree = array();
		$stat_array = array();
		$message_array = array();
		$message_idx = -1;
		$status = S_NULL;
		while(!feof($file_input)){
			++$i;
			$line = trim(fgets($file_input));
			$re = preg_line($line, $matches);
			switch($re){
				case MYNULL:
				case NOTE1:
					continue;break;
				case NOTE2:
					$status = S_NOTE2;
					continue;break;
				case RENOTE2:
					if($status !== S_NOTE2){
						echo "error: unexpected note '*/' at line $i\n";
						return false;
					}
					$status = $stat_array[$stat_idx];
					continue;break;
				case MESSAGE:
					if($status === S_NOTE2)
						continue;
					if($status === S_ENUM){
						echo "error: enum must not have message type at lint $i\n";
						return false;
					}
					$stat_array[++$stat_idx] = $status = S_MESSAGE;
					++$max_idx;
					if($message_idx != -1)
						$parent_idx = $message_array[$message_idx][0];
					$tree[$max_idx] = array('parent_idx'=>$parent_idx,'name'=>$matches[2]);
					$message_array[++$message_idx] = array($max_idx,$matches[2]);
					//dump($message_array);
					if($parent_idx != -1){
						$tree[$parent_idx]['children_idx'][] = $max_idx;
					}
					$cur_idx = $max_idx;
					break;
				case ENUM:
					if($status === S_NOTE2)
						continue;
					if($status !== S_MESSAGE){
						echo "error: missing message type before line $i\n";
						return false;
					}
					if($cur_idx < 0){
						echo "error: missing message type before line $i\n";
						return false;
					}
					$stat_array[++$stat_idx] = $status = S_ENUM;
					$enum_arrays = array();
					while(!feof($file_input)){
						++$i;
						$line = fgets($file_input);
						$length = strlen($line);
						$line = trim($line);
						$re1 = preg_enum_line($line, $matches1);
						$pre_val = 0;
						if($re1){
							if(isset($matches1[2]) && isset($matches1[3])){
								$enum_arrays[$matches1[1]] = intval($matches1[3]);
								$pre_val = $enum_arrays[$matches1[1]];
							}else if(!isset($matches[2]) && !isset($matches1[3])){
								if(count($enum_arrays) > 0)
									$enum_arrays[$matches1[1]] = $pre_val+1;
								else $enum_arrays[$matches1[1]] = $pre_val;
							}else{
								echo "error: illegal enum statement at line $i\n";
								return false;
							}
						}else{
							fseek($file_input, -$length, SEEK_CUR);
							--$i;
							break;
						}
					}
					$tree[$cur_idx]['enum']["{$matches[2]}"] = $enum_arrays;
					break;
				case STAT:
					if($status !== S_MESSAGE){
						echo "error: missing message type before line $i\n";
						return false;
					}
					if($cur_idx < 0){
						echo "error: missing message type before line $i\n";
						return false;
					}
					$format = format_type($matches);
					if($format === false){
						echo "error: illegal line '$line' at line $i\n";
						return false;
					}
					$tree[$cur_idx]['stat'][] = $format;
					break;
				case END:
					if($status === S_NOTE2)
						continue;
					if($status !== S_ENUM && $status !== S_MESSAGE){
						echo "error: illegal end character '}' at line $i\n";
						return false;
					}
					if($status === S_MESSAGE){
						unset($message_array[$message_idx]);
						//dump($message_array);
						--$message_idx;
						if($message_idx != -1){
							$parent_idx = $message_array[$message_idx][0];
						}else{
							$parent_idx = -1;
						}
						$cur_idx = $parent_idx;
					}
					if($stat_idx > 0){
						unset($stat_array[$stat_idx--]);
						$status = $stat_array[$stat_idx];
					}else{
						$stat_array[$stat_idx--];
						$status = S_NULL;
					}
					break;
				case UNKNOWN:
					if($status === S_NOTE2)
						continue;
					echo "error: unknown line at line $i\n";
					return false;
					break;
			}
		}
		if(empty($status_array)){
			return $tree;
		}else{
			echo "error: unexpected end of file at line $i\n";
			return false;
		}
	}else{
		echo "intput file: $input_name is not exist!\n";
		return false;
	}
}
function check_tree(&$tree) {
	foreach ($tree as $idx => &$node) {
		$prefix = get_class_name($tree, $idx);
		$node['class_name'] = $prefix;
	}
	$pair = array();
	foreach ($tree as $idx => &$node) {
		if (isset($node['stat'])) {
			$stat = &$node['stat'];
			foreach ($stat as $index => &$st) {
				if (is_integer($st[1]))	continue;
				//echo "enter type check<br>";
				$curidx = $idx;
				$name = $st[1];
				//echo "type name : $name<br>";
				while ($curidx != -1) {
					$flag = false;
					//echo "curidx: $curidx<br>";
					//check message name
					//echo "check message name<br>";
					if ($name == $tree[$curidx]['name']) {
						//check loop quote
						if (isset($pair[$curidx]) && array_search($idx, $pair[$curidx]) !== false) {
							echo "loop quote between message {$tree[$idx]['name']} and {$tree[$curidx]['name']} at statement {$st['line']}\n";
							return false;
						}
						$pair[$idx][] = $curidx;
						$st[1] = $curidx . '::class::' . $tree[$curidx]['class_name'];
						break;
					}
					//check enum
					//echo "check enum<br>";
					if (isset($tree[$curidx]['enum'])) {
						$enums = array_keys($tree[$curidx]['enum']);
						$searchidx = array_search($name, $enums);
						if ($searchidx !== false) {
							$st[1] = $curidx . '::enum::' . $enums[$searchidx];
							if (isset($st[4])) {
								$enum_array = $tree[$curidx]['enum'][$enums[$searchidx]];
								$enum_keys = array_keys($enum_array);
								$def_idx = array_search($st[4], $enum_keys);
								if ($def_idx !== false) {
									$st[4] = $tree[$curidx]['class_name'] . '::' . $enums[$searchidx] . '_' . $enum_keys[$def_idx];
									$flag = true;
									break;
								}
								echo "undefined enum default value in statement '{$st['line']}'\n";
								return false;
							}
							$flag = true;
							break;
						}
					}
					if ($flag)	break;
					//check children name
					//echo "check children name<br>";
					if (isset($tree[$curidx]['children_idx'])) {
						$children = $tree[$curidx]['children_idx'];
						foreach ($children as $child) {
							if ($name == $tree[$child]['name']) {
								if (isset($pair[$child]) && array_search($idx, $pair[$child]) !== false) {
									echo "loop quote between message {$tree[$idx]['name']} and {$tree[$curidx]['name']}  at statement {$st['line']}\n";
									return false;
								}
								$pair[$idx][] = $child;
								if (isset($st[4])) {
									echo "message type can not set default value in statement '{$st['line']}'\n";
									return false;
								}
								$st[1] = $child . '::class::' . $tree[$child]['class_name'];
								$flag = true;
								break;
							}
						}
					}
					if ($flag)	break;
					$curidx = $tree[$curidx]['parent_idx'];
				}
				//check all the root class name
				if ($curidx == -1) {
					$flag = false;
					//echo "check all the root class name<br>";
					foreach ($tree as $tmpidx => $tmpnode) {
						if ($tmpnode['parent_idx'] == -1 && $name == $tmpnode['name']) {
							if (isset($pair[$tmpidx]) && array_search($idx, $pair[$tmpidx]) !== false) {
								echo "loop quote between message {$tree[$idx]['name']} and {$tree[$curidx]['name']}  at statement {$st['line']}\n";
								return false;
							}
							$pair[$idx][] = $tmpidx;
							if (isset($st[4])) {
								echo "message type can not set default value in statement '{$st['line']}'\n";
								return false;
							}
							$st[1] = $tmpidx . '::class::' . $tmpnode['class_name'];
							$flag = true;
							break;
						}
					}
					if (!$flag) {
						echo "can not find type '{$st[1]}' definition at statement '{$st['line']}'\n";
						return false;
					}
				}
			}
		}
	}
	return true;
}
function get_class_name($tree, $idx) {
	$class_name = '';
	while ($idx != -1) {
		$class_name = '_' . $tree[$idx]['name'] . $class_name;
		$idx = $tree[$idx]['parent_idx'];
	}
	if ($class_name !== '')	$class_name = substr($class_name, 1);
	return $class_name;
}
?>
