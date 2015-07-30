--TEST--
Issue #9 json_decode: invalid UTF-8 characters
--SKIPIF--
<?php if (!extension_loaded('json')) print 'skip'; ?>
--FILE--
<?php
// String
$json = "\"\xC1\xBF\"";
var_dump(json_decode($json));
var_dump(json_last_error());
var_dump(json_last_error_msg());

var_dump(bin2hex(json_decode($json, true, 2, JSON_PARSER_NOTSTRICT)));

// Index
$json = "{\"\xC1\xBF\":\"bar\"}";
var_dump(json_decode($json));
$t = json_decode($json, true, 2, JSON_PARSER_NOTSTRICT);
var_dump(is_array($t) && in_array("bar", $t));

// Property
$json = "{\"foo\":\"\xC1\xBF\"}";
var_dump(json_decode($json));
$t = json_decode($json, true, 2, JSON_PARSER_NOTSTRICT);
var_dump(is_array($t) && array_key_exists("foo", $t));
?>
Done
--EXPECT--	
NULL
int(5)
string(56) "Malformed UTF-8 characters, possibly incorrectly encoded"
string(4) "c1bf"
NULL
bool(true)
NULL
bool(true)
Done
