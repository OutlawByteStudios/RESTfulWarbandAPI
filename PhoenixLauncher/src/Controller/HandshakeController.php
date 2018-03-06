<?php

namespace PhoenixLauncher\src\Controller;

use PhoenixLauncher\src\Service\HandshakeService;

require_once __DIR__ . '/../Service/HandshakeService.php';
class HandshakeController
{
	private $ip, $userAgent, $uid;
	private $HandshakeService;
	
	public function __construct(string $ip, string $userAgent, string $uid)
	{
		$this->ip = $ip;
		$this->userAgent = $userAgent;
		$this->uid = $uid;
		
		try
		{
			$this->HandshakeService = new HandshakeService ();
		}
		catch ( \PDOException $e )
		{
			return [
					'message' => 'Database error',
					'status' => 'error'
			];
		}
	}
	public function process(): array
	{
		
		if (! $HandshakeService->exists ( $this->uid ))
		{
			$uid = $HandshakeService->write ( $this->ip, $this->userAgent );
			return [ 
					'message' => 'Welcome ' . $uid . ', you must be new!',
					'status' => 'success',
					'data' => [ 
							'uid' => $uid 
					] 
			];
		}
		else
		{
			return [ 
					'message' => 'Hello ' . $this->uid . ', weclome back!',
					'status' => 'success',
					'data' => [ 
							'uid' => $this->uid 
					] 
			];
		}
	}
	
	public function washHands()
	{
		$this->HandshakeService->obscure($this->uid);
	}
}