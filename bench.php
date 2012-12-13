<?php
echo "\nPHP  Version: ".phpversion()."\n";
echo "Json Version: ".phpversion('json')."\n\n";

$ary = get_loaded_extensions();
for($i=0; $i<pow(2, 7); $i++){
    $ary = array_merge($ary, range(0, 1024));
	$ary[] = md5("$i");
}

echo "Count: ".count($ary)."\n";

$a = microtime(true);
$jsoned = json_encode($ary);
$b = microtime(true);
printf("Encode in %.5f sec, %ld bytes\n", $b-$a, strlen($jsoned));

file_put_contents("bench.json", $jsoned);

$a = microtime(true);
$json = json_decode($jsoned);
$b = microtime(true);
if ($json) {
    printf("Decode in %.5f sec\n", $b-$a);
} else {
    echo "Decode not inplemented\n";
}

