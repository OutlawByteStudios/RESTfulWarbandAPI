<?php
use PhoenixLauncher\src\Classes\FileController;
use PhoenixLauncher\src\Classes\API;
use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__ . '/../Classes/FileController.php';
require_once __DIR__ . '/../Classes/API.php';

$app->group ( '/v1', function () use ($app)
{
	$app->get ( '/ping', API::class . ':ping');
	
	$this->get ( '/version', API::class . ':version' );
	
	$this->post ( '/handshake', API::class . ':handshake' );
	
	$this->group ( '/repository', function ()
	{
		$this->post ( '/save', FileController::class . ':save' );
		$this->post ( '/delete', FileController::class . ':delete' );
		$this->post ( '/filelist', FileController::class . ':getActiveFiles' );
	} );
} );


