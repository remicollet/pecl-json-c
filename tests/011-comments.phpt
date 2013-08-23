--TEST--
JsonIncremantalParser::parseFile() test
--SKIPIF--
<?php
  if (!extension_loaded("json"))
    die('skip: json extension not available');
  if (!JSON_C_BUNDLED && version_compare(JSON_C_VERSION, "0.11", "le"))
    die('skip: need json-c library > 0.11')
?>
--FILE--
<?php
$ins = array(
    "/ bad comment\n[\"foo\"]",
    "// comment\n[\"foo\"]",
    "/* comment */ [\"foo\"]",
    "[/* comment */ \"foo\"]",
    "[\"/* not a comment */ foo\"]",
);
foreach($ins as $in) {
    echo "Testing: $in\n";
    var_dump(json_decode($in));
    var_dump(json_decode($in, true, 512, JSON_PARSER_NOTSTRICT));
}
echo "Done\n";
?>
--EXPECT--
Testing: / bad comment
["foo"]
NULL
NULL
Testing: // comment
["foo"]
NULL
array(1) {
  [0]=>
  string(3) "foo"
}
Testing: /* comment */ ["foo"]
NULL
array(1) {
  [0]=>
  string(3) "foo"
}
Testing: [/* comment */ "foo"]
NULL
array(1) {
  [0]=>
  string(3) "foo"
}
Testing: ["/* not a comment */ foo"]
array(1) {
  [0]=>
  string(23) "/* not a comment */ foo"
}
array(1) {
  [0]=>
  string(23) "/* not a comment */ foo"
}
Done
