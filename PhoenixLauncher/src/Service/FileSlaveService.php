<?php

namespace PhoenixLauncher\src\Service;

require_once __DIR__ . '/../Service/Configuration.php';
class FileSlaveService
{
	const HASH_ALGO = 'sha512';
	
	private $path;
	private $memoryTable;
	public function __construct()
	{
		$this->path = Configuration::$FILE_SALVE ['base'];
		$this->memoryTable = [ ];
	}
	public function collectHashes()
	{
		$this->getHashes ( $this->path );
		return $this->memoryTable;
	}
	function getHashes($dir, &$results = array())
	{
		$files = scandir ( $dir );
		
		foreach ( $files as $key => $value )
		{
			$path = realpath ( $dir . DIRECTORY_SEPARATOR . $value );
			if (! is_dir ( $path ))
			{
				$this->memoryTable [] = [ 
						$path,
						hash_file ( self::HASH_ALGO, $path ) 
				];
			}
			else if ($value != "." && $value != "..")
			{
				$this->getHashes ( $path, $results );

			}
		}
		
		return $results;
	}

}

