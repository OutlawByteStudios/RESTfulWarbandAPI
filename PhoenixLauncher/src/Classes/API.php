<?php

namespace PhoenixLauncher\src\Classes;

use PhoenixLauncher\src\Controller\FileSlaveController;
use PhoenixLauncher\src\Controller\HandshakeController;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . '/APIResponse.php';
require_once __DIR__ . '/../Controller/HandshakeController.php';
require_once __DIR__ . '/../Controller/FileSlaveController.php';


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
		$parameters = $request->getParsedBody();
		
		if ( !isset($parameters['uid']) || $parameters['uid'] === '')
		{
			return APIResponse::create(['message' => 'uuid not set or empty.','status' => 'error'], 400)->send($response);
		}
		$Handshake = new HandshakeController(null, null, $uid);
		
		return APIResponse::create ( $Handshake->washHands(), 200 )->send ( $response );
	}

	public function save(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
	}
	public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
	}
	public function files(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		$FileSlave = new FileSlaveController();
		
		$start_time=microtime(true);
		
		$files = $FileSlave->getFiles();
		
		$end_time=microtime(true);
		
		return APIResponse::create (  ["time: ". bcsub($end_time, $start_time, 4), "memory (byte): ". memory_get_peak_usage(true) , " processed files: " .count($files), $files] , 200 )->send ( $response );
	}
}

