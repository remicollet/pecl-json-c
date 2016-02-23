--TEST--
Issue #27 json_decode: invalid string to float conversion
--SKIPIF--
<?php if (!extension_loaded('json')) print 'skip'; ?>
--FILE--
<?php
// String
$json = "3.333.3.";
var_dump(json_decode($json));
var_dump(json_last_error());
var_dump(json_last_error_msg());
?>
Done
--EXPECT--
NULL
int(4)
string(12) "Syntax error"
Done
