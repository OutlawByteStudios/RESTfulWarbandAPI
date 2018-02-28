<?php
use PhoenixLauncher\src\Classes\FileController;
use PhoenixLauncher\src\Classes\API;

require_once __DIR__ . '../Classes/FileController.php';
require_once __DIR__ . '../Classes/API.php';

$app->group ( '/v1', function ()
{
	
	$repositoryFileController = new FileController ();
	$APIController = new API ();
	
	$this->get ( '/ping', $APIController->ping ( $request, $response, $args ) );
	$this->get ( '/version', $APIController->getVersion ( $request, $response, $args ) );
	
	$this->post ( '/handshake', $APIController->handshake ( $request, $response, $args ) );
	
	
	$this->group ( '/repository', function () use ($repositoryFileController)
	{
		$this->post ( '/save', $repositoryFileController->save ( $request, $response, $args ) );
		$this->post ( '/delete', $repositoryFileController->delete ( $request, $response, $args ) );
		$this->post ( '/filelist', $repositoryFileController->getActiveFiles ( $request, $response, $args ) );
	} );
	
} );