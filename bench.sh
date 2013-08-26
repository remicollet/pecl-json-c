#!/usr/bin/bash

cd $(dirname $0)

ext=$(php -r 'echo ini_get("extension_dir");')
echo -e "Benchmark of a huge array encode/decode\n";
php -n -d extension_dir=$ext    -d extension=json.so bench.php
php -n -d extension_dir=modules -d extension=json.so bench.php

