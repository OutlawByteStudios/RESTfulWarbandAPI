<?php
namespace PhoenixLauncher\src\Service;

use PhoenixLauncher\src\Classes\Database;

require_once __DIR__ . '/../Classes/Database.php';

class HandshakeService
{
	private $db;
	public function __construct()
	{
		$this->db = Database::init();
		
		if ( !$this->db || !isset($this->db))
		{
			throw new \PDOException("Database Error");
		}
	}
	public function write(string $ip, string $useragent)
	{
		$this->db->prepare('INSERT ');
	}
	public function exists()
	{
		
	}
}

