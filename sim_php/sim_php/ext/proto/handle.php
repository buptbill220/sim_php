<?php
require_once('const.php');
require_once('preg.php');

function format_type($matches){
	$re['line'] = $matches['line'];
	switch($matches[1]){
		case "optional":$re[0] = OPT;break;
		case "required":$re[0] = REQ;break;
		case "repeated":$re[0] = REP;break;
	}
	$re[1] = $matches[2];
	$re[2] = $matches[3];
	$re[3] = intval($matches[4]);
    $re['packed'] = 'false';
	if($re[0] === OPT && isset($matches[5])){
		preg_default_line($matches[5], $matches1);
		if(strpos($matches[2],"int") !== false || strpos($matches[2],"fixed") !== false)
			$re[4] = intval($matches1[1]);
		else if($matches[2] === "float" || $matches[2] === "double")
			$re[4] = floatval($matches1[1]);
		else if($matches[2] == "bool")
			$re[4] = ($matches1[1]=="false")?false:true;
		else
			$re[4] = $matches1[1];
		return $re;
	}
    if ($re[0] === REP && isset($matches[5])) {
        preg_packed_line($matches[5], $matches1);
        $re['packed'] = $matches1[1];
        return $re;
    }
	if($re[0] !== OPT && isset($matches[5]))
		return false;
	return $re;
}
