<?php

namespace PhoenixLauncher\src\Classes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhoenixLauncher\src\Controller\HandshakeController;

require_once __DIR__ . '/APIResponse.php';
class API
{
	const VERSION = 0.1;
	public function getVersion(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
		return APIResponse::create ( [ 
				'message' => 'API version ' . self::VERSION,
				'status' => 'success' 
		], 200 )->send ( $response );
	}
	public function ping(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
		return APIResponse::create ( [ 
				'message' => 'Pong. API is reachable',
				'status' => 'success' 
		], 200 )->send ( $response );
	}
	public function handshake(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
		$ip = $_SERVER ['REMOTE_ADDR'];
		$userAgent = $_SERVER ['HTTP_USER_AGENT'];
		$uid = isset ( $args ['uid'] ) ? $args ['uid'] : '';
		
		$Handshake = new HandshakeController ( $ip, $userAgent, $uid );
		
		$processed = $Handshake->process ();
		
		if (! $processed)
		{
			return APIResponse::create ( [ 
					'message' => 'Welcome back ' . $uid,
					'status' => 'success' 
			], 200 )->send ( $response );
		}
		else
		{
			return APIResponse::create ( [ 
					'message' => 'Hello ' . $uid . ' you must be new, welcome!',
					'status' => 'success' 
			], 200 )->send ( $response );
		}
	}
	public function obscureClient(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
	}
}

