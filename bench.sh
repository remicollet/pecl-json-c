#!/usr/bin/bash

cd $(dirname $0)

ext=$(php -r 'echo ini_get("extension_dir");')
echo -e "Benchmark of a huge array encode/decode\n";
php -n -d extension=$PWD/refmod/json      bench.php
php -n -d extension=$PWD/modules/json.so  bench.php
php -n -d extension=$PWD/refmod/jsond     bench.php
