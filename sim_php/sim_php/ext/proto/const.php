<?php
define("UNKNOWN", -1);
//line
define("MYNULL", 0);	//null line
define("NOTE1", 1);	//note use "//"
define("NOTE2", 2);	//note use "/*"
define("RENOTE2", 3);	//note use "*/"
define("MESSAGE", 4);	//message type
define("ENUM", 5);	//enum type
define("STAT", 6);	//statement
define("END", 7);
//status
define("S_MESSAGE", 1);
define("S_ENUM", 2);
define("S_NULL", 3);
define("S_NOTE1", 4);
define("S_NOTE2", 5);
//embellish
define("REQ", 1);
define("OPT", 2);
define("REP", 3);
//define type
define("DOUBLE", 1);
define("FLOAT",2);
define("INT32", 3);
define("INT64", 4);
define("UINT32", 5);
define("UINT64", 6);
define("SINT32", 7);
define("SINT64", 8);
define("FIXED32", 9);
define("FIXED64", 10);
define("SFIXED32", 11);
define("SFIXED64", 12);
define("BOOL", 13);
define("STRING", 14);
define("BYTES", 15);
?>