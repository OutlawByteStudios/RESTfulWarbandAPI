<?php

namespace PhoenixLauncher\src\Controller;

use PhoenixLauncher\src\Service\HandshakeService;

class HandshakeController
{
	private $ip, $userAgent, $uid;
	public function __construct(string $ip, string $userAgent, string $uid)
	{
		$this->ip = $ip;
		$this->userAgent = $userAgent;
		$this->uid = $uid;
	}
	public function process(): string
	{
		$HandshakeService = new HandshakeService ();
		
		if (! $HandshakeService->exists ( $this->uid ))
		{
			return $HandshakeService->write ( $this->ip, $this->useragent );
		}
		else
		{
			return false;
		}
	}
}