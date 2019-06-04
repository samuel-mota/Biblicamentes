<?php
require_once 'db-config.php';

//https://www.php.net/manual/en/function.spl-autoload-register.php
spl_autoload_register('loadClass'); //repassa o nome e chama a função se a classe for chamada

function loadClass($classCalled) {
	if (file_exists('classes/' . $classCalled . '.php')) { //https://www.php.net/manual/en/function.file-exists.php
		require_once('classes/' . $classCalled . '.php');
	}
}