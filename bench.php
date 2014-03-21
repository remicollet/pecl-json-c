<?php
echo "\nPHP  Version: ".phpversion()."\n";
if (extension_loaded('jsond')) {
	$ver = "pecl/jsond ".phpversion('jsond');
	$suf = "jsond";
	$enc = 'jsond_encode';
	$dec = 'jsond_decode';
	$opt = JSOND_PRETTY_PRINT;
} else if (version_compare(phpversion('json'), '1.3.0', '<')) {
	$ver = "ext/json   ".phpversion('json');
	$suf = "json";
	$enc = 'json_encode';
	$dec = 'json_decode';
	$opt = JSON_PRETTY_PRINT;
} else {
	$ver = "pecl/jsonc ".phpversion('json');
	$suf = "jsonc";
	$enc = 'json_encode';
	$dec = 'json_decode';
	$opt = JSON_PRETTY_PRINT;
}

echo "Json Version: ".$ver."\n\n";

$ary = get_loaded_extensions();
for($i=0; $i<pow(2, 8); $i++){
	// integers
	$ary = array_merge($ary, range(0, 1024));
	// strings
	$ary[] = md5("$i");
	// floats
	$ary[] = (float)count($ary)/100;
}

echo "Count: ".count($ary)."\n";

$a = microtime(true);
$jsoned = $enc($ary);
$b = microtime(true);
printf("Encode in %.5f sec, %ld bytes\n", $b-$a, strlen($jsoned));

file_put_contents("bench.$suf", $enc($ary, $opt));

$a = microtime(true);
$json = $dec($jsoned);
$b = microtime(true);
if ($json) {
    printf("Decode in %.5f sec\n", $b-$a);
} else {
    echo "Decode not implemented\n";
}
/*
if (class_exists("JsonIncrementalParser")) {
    $a = microtime(true);
    $json = json_decode(file_get_contents("bench.json"));
    $b = microtime(true);
    if ($json) {
        printf("Decode from memory in %.5f sec\n", $b-$a);
    }
    $a = microtime(true);
    $p = new JsonIncrementalParser();
    $p->parseFile("bench.json");
    $json = $p->get();
    $b = microtime(true);
    if ($json) {
        printf("Decode from file in   %.5f sec\n", $b-$a);
    }
}
*/
