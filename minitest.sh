#!/usr/bin/bash

#php -n -d extension_dir=modules -d extension=json.so --re json

php -n -d extension_dir=modules -d extension=json.so <<EOF
<?php
echo "PHP  Version: ".phpversion()."\n";
echo "Json Version: ".phpversion('json')."\n";

echo "\nNULL:         ".json_encode(NULL);
echo "\nTrue:         ".json_encode(true);
echo "\nFalse:        ".json_encode(false);
echo "\nInteger:      ".json_encode(123);
echo "\nAscii String: ".json_encode("foo");
echo "\nUTF-8 String: ".json_encode("réunion");
echo "\nDone\n";
EOF

