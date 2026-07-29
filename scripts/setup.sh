#!/bin/bash

mkdir -p public/assets/css
mkdir -p public/assets/img
mkdir -p public/assets/js
mkdir -p public/uploads
mkdir -p tests

chmod 777 public/uploads

if [ ! -f app/Config.php ]; then
	cp app/Config.example.php app/Config.php
else
	echo "Config.php file already exists."
fi
