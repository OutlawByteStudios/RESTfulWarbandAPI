<?php
use PhoenixLauncher\src\Classes\API;
use PhoenixLauncher\src\Controller\FileSlaveController;


require_once __DIR__ . '/../Controller/FileSlaveController.php';
require_once __DIR__ . '/../Classes/API.php';


$app->group ( '/v1', function () use ($app)
{
	$app->get ( '/ping', API::class . ':ping');
	$app->get ( '/version', API::class . ':version' );
	$app->get ( '/handshake', API::class . ':handshake' );
	$app->post( '/washhands', API::class . ':obscureClient');
	


	$app->group ( '/repository', function () use ($app)
	{
		$app->get ( '/getPackage[/{target}]', API::class . ':getPackage');
;
		$app->get ( '/generatePackage[/{target}]', function ($request, $response, $args)
		{
			return (new API())->generatePackage($request, $response, $args);
		} );
		
		$app->get ( '/file', API::class . ':file' );
	} );
	
	$app->group ( '/launcher', function () use ($app)
	{
		$app->get ( '/version', API::class . ':launcherVersion' );
		
		$app->get ( '/download', API::class . ':launcherDownload' );

		$app->get ( '/updater', API::class . ':updaterDownload' );
	} );
} );


