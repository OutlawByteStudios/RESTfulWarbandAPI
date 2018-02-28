<?php

namespace PhoenixLauncher\src\Classes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . '/APIResponse.php';

class API
{
	const VERSION = 0.1;
	public function handshake(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
	}
	public function getVersion(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
		return APIResponse::create(
				[
						'message' => 'API version ' . self::VERSION ,
						'status' => 'success'
				], 200)->send($response);
		
	}
	public function ping(ServerRequestInterface $request, ResponseInterface $response, array $args)
	{
		return APIResponse::create(
				[
				'message' => 'Pong. API is reachable',
				'status' => 'success'
				], 
				200)->send($response);
	}
}

