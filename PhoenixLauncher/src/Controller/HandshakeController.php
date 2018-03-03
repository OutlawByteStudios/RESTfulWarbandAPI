<?php
namespace PhoenixLauncher\src\Controller;

class HandshakeController
{
	private $ip, $userAgent;
	
	
	public function __construct(string $ip, string $userAgent)
	{
		$this->ip = $ip;
		$this->userAgent = $userAgent;

	}
	
	public function process(): string
	{
		
	}
}