<?php

//PDO (PHP Data Objects) https://www.php.net/manual/en/class.pdo.php
//Represents a connection between PHP and a database server.

class Connect {
	public static function getConnection() {
		//:host=LOCATION; dbname=NOME-DO-BD; charset=utf8 (para mostrar os acentos corretamente), USUARIO, SENHA
		$connection = new PDO(DB_DRIVE . ":host=" . DB_HOSTNAME . ";dbname=" . DB_DATABASE . ";charset=utf8", DB_USERNAME, DB_PASSWORD); 
		
		//https://www.php.net/manual/en/pdo.setattribute.php
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $connection;
	}
} 