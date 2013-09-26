--TEST--
Decode value with null-byte (key not yet properly decode)
--SKIPIF--
<?php
  if (!extension_loaded("json"))
    die('skip: json extension not available');
?>
--FILE--
<?php
echo bin2hex(json_decode('"foo\u0000bar"'));
echo "\nDone\n";
?>
--EXPECT--
666f6f00626172
Done
