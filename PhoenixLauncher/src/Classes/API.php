<?php

namespace PhoenixLauncher\src\Classes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhoenixLauncher\src\Controller\HandshakeController;

require_once __DIR__ . '/APIResponse.php';
require_once __DIR__ . '/../Controller/HandshakeController.php';

class API
{
	const VERSION = 0.3;
	public function version(ServerRequestInterface $request, ResponseInterface $response, array $args)
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
		
		
		$parameters = $request->getQueryParams();
		$ip = $_SERVER ['REMOTE_ADDR'];
		$userAgent = $_SERVER ['HTTP_USER_AGENT'];
		
		$uid = isset ( $parameters ['uid'] ) ? $parameters ['uid'] : '';

		$Handshake = new HandshakeController ( $ip, $userAgent, $uid );

		return APIResponse::create ( $Handshake->process (), 200 )->send ( $response );

	}
	public function obscureClient(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
	}
}

