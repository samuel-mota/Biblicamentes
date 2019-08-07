<?php
//https://www.php.net/manual/en/function.define.php  
//define('name', 'value');

define('DEBUG', false); // true = modo produção, false = modo não produção

// items do banco de dados
// DB_DRIVE:host=DB_HOSTNAME;dbname=DB_DATABASE, DB_USERNAME, DB_PASSWORD
define ('DB_DRIVE', 'mysql');
define ('DB_HOSTNAME', 'localhost:3308'); //localhost
define ('DB_DATABASE', 'biblicamentes');
define ('DB_USERNAME', 'root'); //root
define ('DB_PASSWORD', '');

// classe Connect chama essas configurações