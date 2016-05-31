--TEST--
Issue #28 json_decode: result when we decode number with "-" in bad position
--INI--
precision=14
--SKIPIF--
<?php if (!extension_loaded('json')) print 'skip'; ?>
--FILE--
<?php
$cases = array(
	'-1',
	'1e-1',
	'1-',
	'333-22-3',
	'-1e1-',
	'-',
);
foreach ($cases as $case) {
	var_dump(json_decode($case));
}
?>
Done
--EXPECT--	
int(-1)
float(0.1)
NULL
NULL
NULL
NULL
Done
