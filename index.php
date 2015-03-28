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
  $app->get('/job/:id', function ( $id ) use ( $app ) {
    try {
      $job = Job::find($id);
      echo $job->to_json();
    } catch ( ActiveRecord\RecordNotFound $e ) {
      $app->response->setStatus( 404 );
    }
  });


  $app->run();

