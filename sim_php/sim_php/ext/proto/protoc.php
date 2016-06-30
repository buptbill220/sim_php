<?php
require_once('analize.php');
require_once('compile.php');
require_once('BaseClass.php');

//$argv[1] = '';
$input_name = $argv[1];
if($input_name == '')
	$input_name = 'tanx-bidding.proto';
echo "input file is: $input_name\n";
$tree = analize($input_name);
if($tree === false){
	echo "analysis file $input_name failed!\n";
	exit(-1);
}
//var_dump($tree);
$flag = check_tree($tree);
if (!$flag) {
	echo "error, grammatical mistake occured!\n";
	exit(-1);
}
//dump($tree);
$output_name = get_output_file($input_name);
echo "output file is $output_name\n";
$flag = compile_tree($tree, $output_name);
?>
