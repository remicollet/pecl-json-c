<?php
class Mini {
    public $prop;
    
    function __construct($val) {
        $this->prop = $val;
    }
}
echo "\nPHP  Version: ".phpversion()."\n";
echo "Json Version: ".phpversion('json')."\n";

echo "\nNULL:         ".json_encode(NULL);
echo "\nTrue:         ".json_encode(true);
echo "\nFalse:        ".json_encode(false);
echo "\nInteger:      ".json_encode(123);
echo "\nAscii String: ".json_encode("foo");
echo "\nUTF-8 String: ".json_encode("réunion");
echo "\nArray1: ".json_encode(array(2,4,6));
echo "\nArray1: ".json_encode(array(2,NULL,6));
echo "\nArray2: ".json_encode(array(2,4,6), JSON_FORCE_OBJECT);
echo "\nObject: ".json_encode(new Mini("foo"));
echo "\nDone\n";

