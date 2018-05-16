<?php

namespace PhoenixLauncher\src\Classes;

use PhoenixLauncher\src\Controller\FileSlaveController;
use PhoenixLauncher\src\Controller\HandshakeController;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhoenixLauncher\src\Service\FileSlaveService;

require_once __DIR__ . '/APIResponse.php';
require_once __DIR__ . '/../Controller/HandshakeController.php';
require_once __DIR__ . '/../Controller/FileSlaveController.php';


class API
{
	const VERSION = "0.7.6";
	const LAUNCHER_VERSION = "0.7.2";

	const UPDATE_AVAILABLE = "200";
	const UPDATE_REQUIRED = "300";

	const UPDATE_STATUS = "300";

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

	public function getPackage(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		
		if ( !isset($args['target']) || $args['target'] === '')
		{
			return APIResponse::create (  ['message' => 'Target Package is not specified'] , 400 )->send ( $response );
	
		}
		$start_time=microtime(true);
		$FileSlave = new FileSlaveController();

		$files = $FileSlave->getPackage($args['target']);
		$end_time=microtime(true);

		return APIResponse::create (  ['message' => $files] , 200 )->send ( $response );
	}

	public function generatePackage(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		if ( !isset($args['target']) || $args['target'] === '')
		{
			return APIResponse::create (  ['message' => 'Target Package is not specified'] , 400 )->send ( $response );
	
		}

		$FileSlave = new FileSlaveController();
		
		$start_time=microtime(true);
		
		$files = $FileSlave->generatePackage($args['target']);
		
		$end_time=microtime(true);
		
		return APIResponse::create (  ['message' => $files] , 200 )->send ( $response );
	
	}

	public function file(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		
		$parameters = $request->getQueryParams();
		
		if ( !isset($parameters['filename']) || $parameters['filename'] === '')
		{
			return APIResponse::create(['message' => 'filename not set or empty.','status' => 'error'], 400)->send($response);
		}
		
		$FileSlave = new FileSlaveService();
		//'debug' => gzencode ("test") , 
		//return APIResponse::create (  ["time: ". bcsub($end_time, $start_time, 4), "memory (byte): ". memory_get_peak_usage(true) , " processed files: " .count($files), 'data' => $files] , 200 )->send ( $response );
		
		
		$compressedStr = gzencode(base64_encode($FileSlave->getFile($parameters['filename'])));
		
		
		return $response->withHeader('Transfer-Encoding', 'gzip')
		->withStatus(200)
		->withHeader('Content-Encoding', 'gzip')
		->withHeader('Content-Type', 'text/plain')
		->withHeader('Content-Length', strlen($compressedStr))
		->write($compressedStr);

	}

	public function launcherVersion(ServerRequestInterface $request, ResponseInterface $response, $args)
	{

		return $response->withStatus(200)
		->withHeader('Content-Type', 'application/json')
		->write(json_encode([
			'version' => self::LAUNCHER_VERSION,
			'type' => self::UPDATE_STATUS
			]));
	}
	public function launcherDownload(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		$FileSlave = new FileSlaveService();
		$compressedLauncher = gzencode(base64_encode($FileSlave->getLauncher()));

		return $response->withHeader('Transfer-Encoding', 'gzip')
		->withStatus(200)
		->withHeader('Content-Encoding', 'gzip')
		->withHeader('Content-Type', 'text/plain')
		->withHeader('Content-Length', strlen($compressedLauncher))
		->write($compressedLauncher);
	}

	public function updaterDownload(ServerRequestInterface $request, ResponseInterface $response, $args)
	{
		$FileSlave = new FileSlaveService();
		$compressedUpdater = gzencode(base64_encode($FileSlave->getUpdater()));

		return $response->withHeader('Transfer-Encoding', 'gzip')
		->withStatus(200)
		->withHeader('Content-Encoding', 'gzip')
		->withHeader('Content-Type', 'text/plain')
		->withHeader('Content-Length', strlen($compressedUpdater))
		->write($compressedUpdater);
	}
}

