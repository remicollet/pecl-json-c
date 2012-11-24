<?php
class Mini {
    public $prop1;
    public $prop2;
    
    function __construct($val1, $val2) {
        $this->prop1 = $val1;
        $this->prop2 = $val2;
    }
}
class MiniSer1 extends Mini implements JsonSerializable {
    public function jsonSerialize(){
        return array("One" => $this->prop1, "Two" => $this->prop2);
    }
}
class MiniSer2 extends Mini implements JsonSerializable {
    public function jsonSerialize(){
        return $this;
    }
}

echo "\nPHP  Version: ".phpversion()."\n";
echo "Json Version: ".phpversion('json')."\n";

echo "\nEncode\n";
echo "\nNULL:         ".json_encode(NULL);
echo "\nTrue:         ".json_encode(true);
echo "\nFalse:        ".json_encode(false);
echo "\nInteger:      ".json_encode(123);
echo "\nAscii String: ".json_encode("foo");
echo "\nString 1:     ".json_encode("x'x");
echo "\nString 2:     ".json_encode('y"y');
echo "\nAscii String: ".json_encode("foo");
echo "\nUTF-8 String: ".json_encode("réunion");
echo "\nArray1:       ".json_encode(array(2,4,6));
echo "\nArray2:       ".json_encode(array(2,NULL,6));
echo "\nArray as Obj: ".json_encode(array(2,4,6), JSON_FORCE_OBJECT);
echo "\nObject1:      ".json_encode(new Mini("foo", "bar"));
echo "\nObject2:      ".json_encode(new Mini("foo", NULL));
echo "\nObject Ser 1: ".json_encode(new MiniSer1("foo", "bar"));
echo "\nObject Ser 2: ".json_encode(new MiniSer2("foo", "bar"));

echo "\nDecode\n";
echo "null:         "; var_dump(json_decode("null"));
echo "123:          "; var_dump(json_decode("123"));
echo "3.14:         "; var_dump(json_decode("3.14"));
echo "true:         "; var_dump(json_decode("true"));
echo "false:        "; var_dump(json_decode("false"));
echo "string 1:     "; var_dump(json_decode('"foo"'));
echo "string 2:     "; var_dump(json_decode('"r\u00e9union"'));
echo "string 3:     "; var_dump(json_decode('"x\'x"'));
echo "string 4:     "; var_dump(json_decode('"y\"y"'));

echo "\nDone\n";

