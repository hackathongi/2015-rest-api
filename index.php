<?php

	require 'vendor/autoload.php';
	require 'bddConnector.php';

	$app = new \Slim\Slim();
	$connector = new egapiConn();

	$app->get('/', function ( ) use ( $app, $connector ) {
	    echo "Hello HackaJobs";
	});

	/**
	 * Families
	 */
	$app->get('/families/:token', function ( $token ) use ( $app, $connector ) {
		if ( rightToken( $token ) ) {
	    	$connector->getFamilies();
		}
		else {
			$app->response->setStatus( 400 );
		}
	});


	$app->run();
