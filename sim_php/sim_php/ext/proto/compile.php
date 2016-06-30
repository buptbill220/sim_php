<?php
require_once('const.php');
require_once('normalization.php');

function compile_tree(&$tree, $output_name) {
	if (($output_file = fopen($output_name, 'w')) === false) {
		echo "can not open file $output_name\n";
		return false;
	}
	//write header
	$header = "<?php\nrequire_once('const.php');\n";
	$header .= "require_once('BaseClass.php');\n\n";
	fwrite($output_file, $header);
	
	foreach ($tree as $idx => $node) {
		write_header($output_file, $node['class_name']);
		write_body($output_file, $tree, $idx);
		fwrite($output_file, "}\n");
	}
	write_tail($output_file);
	fclose($output_file);
	return true;
}
function write_header($file, $class_name) {
	$header = "class $class_name extends BaseClass {\n";
	fwrite($file, $header);
}
function write_body($file, &$tree, $idx) {
	$node = &$tree[$idx];
	//enum write
	if (isset($node['enum'])) {
		$enums = $node['enum'];
		foreach ($enums as $ename => $earray) {
			fwrite($file, "\t//enum '$ename' definition\n");
			foreach ($earray as $e => $v) {
				$newe = $ename . '_' . $e;
				fwrite($file, "\tconst {$newe} = {$v};\n");
			}
		}
	}
	//statement write
	if (isset($node['stat'])) {
		$stat = $node['stat'];
		foreach ($stat as $value) {
			$note = "\t//{$value['line']}\n";
			fwrite($file, $note);
			$define = gen_define_code($value);
			fwrite($file, $define);
			$tmp = $value;
			unset($tmp['line']);
			unset($tmp[2]);
			$ar = explode('::', $tmp[1]);
			if (count($ar) == 3) {
				$tmp[1] = "'" . $ar[1] . "'";
				if ($ar[1] === 'class')
					$tmp[4] = "'{$ar[2]}'";
			}
            $packed = $tmp['packed'];
            unset($tmp['packed']);
			$vprt = implode(',',$tmp);
			fwrite($file, "\tpublic \${$value[2]}_prt = array({$vprt},'packed' => $packed);\n");
			if ($value[0] === OPT) {
				$func = gen_opt_code($value);
			} elseif ($value[0] === REP) {
				$func = gen_rep_code($value);
			} else {
				$func = '';
			}
			fwrite($file, $func);
			$func = gen_clear_code($value);
			fwrite($file, $func);
		}
	}
}
function gen_define_code($value) {
	if (isset($value[4])) {
		$define = "\tpublic \${$value[2]} = {$value[4]};\n";
	} else {
		$define = "\tpublic \${$value[2]};\n";
	}
	return $define;
}
function gen_opt_code($value) {
	$func = <<<EOT
	function has_{$value[2]}() {
		if (isset(\$this->{$value[2]}))	return true;
		return false;
	}

EOT;
	return $func;
}
function gen_rep_code($value) {
	$ar = explode('::', $value[1]);
	if (count($ar) === 3) {
		$value[1] = "'" . $ar[1] . "'";
	}
	$func = <<<EOT
	function size_{$value[2]}() {
		if (isset(\$this->{$value[2]}))	return count(\$this->{$value[2]});
		return 0;
	}
	function {$value[2]}(\$index) {
		if (is_numeric(\$index) && intval(\$index) == \$index)
			\$index = intval(\$index);
		if (!is_integer(\$index) || \$index < 0 || \$index >= \$this->size_{$value[2]}())
			return false;
		\${$value[2]} = \$this->{$value[2]};
		return \${$value[2]}[\$index];
	}

EOT;
	if (count($ar) == 3 && $ar[1] == 'class') {
		$func .= <<<EOT
	function add_{$value[2]}(\$ele) {
		if (!\$this->validate_type({$value[1]}, \$ele) || empty(\$ele)){
			if (is_object(\$ele))	\$ele = 'object';
			if (is_array(\$ele))	\$ele = 'array';
			echo "add element '\$ele' error in function " . __FUNCTION__ . ",element is not class";
			return false;
		}
		if (\$ele instanceof {$ar[2]}) {
			\$this->{$value[2]}[] = \$ele;
			return true;
		}
		
		echo "add element '[object]' error in function " . __FUNCTION__ . ",element is not class type of {$ar[2]}";
		return false;
	}

EOT;
	} else {
		$func .= <<<EOT
	function add_{$value[2]}(\$ele) {
		if (isset(\$ele) && \$this->validate_type({$value[1]}, \$ele)) {
			\$this->{$value[2]}[] = \$ele;
			return true;
		}
		if (is_object(\$ele))	\$ele = '[object]';
		if (is_array(\$ele))	\$ele = '[array]';
		echo "add element '\$ele' error in function " . __FUNCTION__ . ", dismatch type";
		return false;
	}

EOT;
	}
	return $func;
}
function gen_clear_code($value) {
	$func = <<<EOT
	function clear_{$value[2]}() {
		if (isset(\$this->{$value[2]}))
			unset(\$this->{$value[2]});

EOT;
	if (isset($value[4])) {
		$func .= <<<EOT
		\$this->{$value[2]} = {$value[4]};

EOT;
	}
	$func .= "\t}\n";
	return $func;
}
function write_tail($file) {
	$tail = "?>";
	fwrite($file, $tail);
}
?>
