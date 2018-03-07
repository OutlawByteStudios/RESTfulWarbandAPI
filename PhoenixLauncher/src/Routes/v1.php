<?php
use PhoenixLauncher\src\Classes\API;
use PhoenixLauncher\src\Controller\FileSlaveController;



require_once __DIR__ . '/../Controller/FileSlaveController.php';

require_once __DIR__ . '/../Classes/API.php';

$app->group ( '/v1', function () use ($app)
{
	$app->get ( '/ping', API::class . ':ping');
	$this->get ( '/version', API::class . ':version' );
	$this->get ( '/handshake', API::class . ':handshake' );
	$this->post('/washhands', API::class . ':obscureClient');
	
	
	$this->group ( '/repository', function ()
	{
		$this->post ( '/save', API::class . ':save' );
		$this->post ( '/delete', API::class . ':delete' );
		$this->post ( '/filelist[/{target}]', API::class . ':files' );
		$this->post ( '/file/{id}', function(){} );
	} );
	
} );


