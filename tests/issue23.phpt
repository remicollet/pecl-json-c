--TEST--
Issue #23 json_decode: single quote in property name
--INI--
precision=14
--SKIPIF--
<?php if (!extension_loaded('json')) print 'skip'; ?>
--FILE--
<?php
$json = "{'foo': \"bar\"}";
var_dump(json_decode($json));
var_dump(json_decode($json, true, 2, JSON_PARSER_NOTSTRICT));
?>
Done
--EXPECT--	
NULL
array(1) {
  ["foo"]=>
  string(3) "bar"
}
Done
