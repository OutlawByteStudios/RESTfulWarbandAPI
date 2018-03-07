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
		$uid = uniqid('auth');
		$query = $this->db->prepare('INSERT INTO users (ip, user_agent, uid) VALUES (?,?,?)');
		$query->bindValue(1, $ip);
		$query->bindValue(2, $useragent);
		$query->bindValue(3, $uid);
		$query->execute();
		
		return $uid;
	}
	public function exists(string $uid): bool
	{
		$query = $this->db->prepare('SELECT id FROM users WHERE uid = ?');
		$query->bindValue(1, $uid);
		$query->execute();
		
		return count($query->fetchAll()) > 0 ? true : false;
	}
	public function obscure(string $uid): void
	{
		$query = $this->db->prepare('UPDATE users SET ip=null WHERE uid = ?');
		$query->bindValue(1, $uid);
		$query->execute();
		
		return;
	}
}

