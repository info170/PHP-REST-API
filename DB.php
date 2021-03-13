<?php

class DB
{
	public static function connect() {

		$connectionParams = array(
		    'dbname' => 'test',
		    'user' => 'root',
		    'password' => '',
		    'host' => '127.0.0.1',
		    'port' => '3306',
		    'driver' => 'pdo_mysql',
		);

		return \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
	}
}