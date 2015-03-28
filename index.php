<?php

  require 'vendor/autoload.php';
  require 'bddConnector.php';
  require 'hackjobsUtils.php';

  $app = new \Slim\Slim();

  $app->get('/', function ( ) use ( $app ) {
      echo "Hello HackaJobs";
  });

  /**
   * Job
   */
  $app->get('/job/:token', function ( $token ) use ( $app ) {
    if ( $token ) {
      $job = Job::find(1);
      echo $job->to_json();
    }
    else {
      $app->response->setStatus( 400 );
    }
  });


  $app->run();

