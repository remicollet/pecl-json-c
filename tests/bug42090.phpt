--TEST--
Bug #42090 (json_decode causes segmentation fault)
--SKIPIF--
<?php
  if (!extension_loaded("json"))
    die('skip: json extension not available');
  if (!JSON_C_BUNDLED && version_compare(JSON_C_VERSION, "0.11", "le"))
    die('skip: need json-c library > 0.11')
?>
--FILE--
<?php
var_dump(
	json_decode('""'),
	json_decode('"..".'),
	json_decode('"'),
	json_decode('""""'),
	json_encode('"'),
	json_decode(json_encode('"')),
	json_decode(json_encode('""'))
);
?>
--EXPECT--
string(0) ""
NULL
NULL
NULL
string(4) ""\"""
string(1) """
string(2) """"
