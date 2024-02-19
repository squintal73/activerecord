<?php

require "vendor/autoload.php";

use app\classes\Bind;
use app\database\connection\Connection;

$config = require "config.php";

Bind::set('config', $config);
Bind::set('connection', Connection::connect());
