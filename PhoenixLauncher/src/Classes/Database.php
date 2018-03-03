<?php
namespace PhoenixLauncher\src\Classes;

class Database
{
	public static function init()
	{
		$path = realpath(__DIR__ . '/../DB/clients.dat');
		
		try {
			return new \PDO('sqlite:' . $path);
		}catch(\PDOException $e)
		{
			return false;
		}
		return null;
	}
}