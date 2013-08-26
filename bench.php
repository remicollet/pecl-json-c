<?php
echo "\nPHP  Version: ".phpversion()."\n";
if (version_compare(phpversion('json'), '1.3.0', '<'))
	$ver = "ext/json ".phpversion('json');
else
	$ver = "pecl/jsonc ".phpversion('json');

echo "Json Version: ".$ver."\n\n";

$ary = get_loaded_extensions();
for($i=0; $i<pow(2, 7); $i++){
    $ary = array_merge($ary, range(0, 1024));
	$ary[] = md5("$i");
	$ary[] = microtime(true);
}

echo "Count: ".count($ary)."\n";

$a = microtime(true);
$jsoned = json_encode($ary);
$b = microtime(true);
printf("Encode in %.5f sec, %ld bytes\n", $b-$a, strlen($jsoned));

file_put_contents("bench.json", json_encode($ary, JSON_PRETTY_PRINT));

$a = microtime(true);
$json = json_decode($jsoned);
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
