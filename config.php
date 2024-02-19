<?php

return [
    'database' => [
        'host' => 'localhost',
        'dbname' => 'activerecord',
        'username' => 'root',
        'password' => 'new123',
        'charset' => 'utf8',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ],
    ],
    'email' => [
    ],
];
