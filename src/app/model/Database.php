<?php

Class Database {

	public $pdoObject = null;

	function __construct() {
		$this->pdoObject = Self::createConnection();
	}

	private function createConnection() {

		return new PDO("pgsql:host=" . $_ENV['DB_HOST'] . ((empty($_ENV['DB_PORT'])) ? null : ";port=" . $_ENV['DB_PORT']) . ";dbname=" . $_ENV['DB_DATABASENAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
            PDO::ATTR_PERSISTENT => true
		));
	}

	public function query($query){

		return $this->pdoObject->query($query);
	}

	public function prepare($query){
		
		return $this->pdoObject->prepare($query);
	}

	public function execute($array = null){

		return $array;
	}

}
