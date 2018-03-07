<?php

namespace PhoenixLauncher\src\Controller;

use PhoenixLauncher\src\Service\FileSlaveService;

require_once __DIR__ . '/../Service/FileSlaveService.php';

class FileSlaveController
{
	public function __construct()
	{
		
	}
	
	public function getFiles()
	{
		$Slave = new FileSlaveService();
		return $Slave->collectHashes();
	}
	
	
}

