#!/usr/bin/bash

#php -n -d extension_dir=modules -d extension=json.so --re json

php minitest.php
php -n -d extension_dir=modules -d extension=json.so minitest.php

