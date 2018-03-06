<?php
use PhoenixLauncher\src\Controller\FileController;
use PhoenixLauncher\src\Classes\API;



require_once __DIR__ . '/../Controller/FileController.php';

require_once __DIR__ . '/../Classes/API.php';

$app->group ( '/v1', function () use ($app)
{
	$app->get ( '/ping', API::class . ':ping');
	$this->get ( '/version', API::class . ':version' );
	$this->get ( '/handshake', API::class . ':handshake' );
	$this->post('/washhands', API::class . ':obscureClient');
	
	
	$this->group ( '/repository', function ()
	{
		$this->post ( '/save', FileController::class . ':save' );
		$this->post ( '/delete', FileController::class . ':delete' );
		$this->post ( '/filelist', FileController::class . ':getActiveFiles' );
		$this->post ( '/file/{id}', function(){} );
		$this->post ( '/filelist[/{target}]', function(){} );
	} );
	
} );


