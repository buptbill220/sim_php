<?php
require_once('const.php');

function preg_line($line, &$matches = null){
	$line = preg_replace('/^(\s*.+?)\s*\/\/.*/', '$1', $line);
	//echo "format line: $line\n";
	if($line == '')
		return MYNULL;
	if(preg_match('/^\s*(message)\s+(\w+)\s*\{\s*$/',$line, $matches))
		return MESSAGE;
	if(preg_match('/^\s*(required|optional|repeated)\s+(\w+)\s+(\w+)\s*=\s*(\d+)(\s+\[\s*(default|packed)\s*=\s*.+\])?\s*;\s*$/',
			$line, $matches)) {
		$matches[2] = format_data_type($matches[2]);
		$matches['line'] = $line;
		return STAT;
	}
	if(preg_match('/^\s*(enum)\s*(\w+)\s*{\s*$/', $line, $matches))
		return ENUM;
	if(preg_match('/^\s*\/\*/', $line))
		return NOTE2;
	if(preg_match('/^\s*\/\//', $line))
		return NOTE1;
	if(preg_match('/\*\/\s*(\/\/.*)?$/', $line))
		return RENOTE2;
	if(preg_match('/^\s*\}\s*$/', $line))
		return END;
	return UNKNOWN;
}
function preg_enum_line($line, &$matches = null){
	if(preg_match('/^\s*([A-Z_]+)\s*(=)?\s*(-?\d+)?\s*;\s*$/', $line, $matches))
		return true;
	return false;
}
function preg_default_line($line, &$matches = null){
	if(preg_match('/\s+\[\s*default\s*=\s*(.+)\]$/', $line, $matches))
		return true;
	return false;
}
function preg_packed_line($line, &$matches = null) {
	if(preg_match('/\s+\[\s*packed\s*=\s*(.+)\]$/', $line, $matches))
		return true;
	return false;
}
function format_data_type($type) {
	switch ($type) {
		case 'double':$re = DOUBLE;break;
		case 'float':$re = FLOAT;break;
		case 'int32':$re = INT32;break;
		case 'int64':$re = INT64;break;
		case 'uint32':$re = UINT32;break;
		case 'uint64':$re = UINT64;break;
		case 'sint32':$re = SINT32;break;
		case 'sint64':$re = SINT64;break;
		case 'fixed32':$re = FIXED32;break;
		case 'fixed64':$re = FIXED64;break;
		case 'sfixed32':$re = SFIXED32;break;
		case 'sfixed64':$re = SFIXED64;break;
		case 'bool':$re = BOOL;break;
		case 'string':$re = STRING;break;
		case 'bytes':$re = BYTES;break;
		default:$re = $type;
	}
	return $re;
}
?>
