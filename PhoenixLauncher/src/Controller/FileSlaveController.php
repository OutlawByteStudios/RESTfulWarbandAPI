<?php

namespace PhoenixLauncher\src\Controller;

use PhoenixLauncher\src\Service\FileSlaveService;

require_once __DIR__ . '/../Service/FileSlaveService.php';

class FileSlaveController
{
	public function __construct()
	{
		
	}
	
	public function generatePackage($package)
	{
		$Slave = new FileSlaveService();
		return $Slave->collectHashes($package);
	}

	public function getPackage($package)
	{
		$Slave = new FileSlaveService();
		return $Slave->package($package);
	}
	
}

