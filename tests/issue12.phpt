--TEST--
Issue #12 json_decode: fails with number int frac
--INI--
precision=14
--SKIPIF--
<?php if (!extension_loaded('json')) print 'skip'; ?>
--FILE--
<?php

var_dump(json_decode('.1'));
?>
Done
--EXPECT--	
float(0.1)
Done
