<?php

  require 'vendor/autoload.php';
  require 'bddConnector.php';

  $app = new \Slim\Slim();

  $app->get('/', function ( ) use ( $app ) {
      echo "Hello HackaJobs";
  });

  /**
   * Jobs API
   */

  $app->get('/jobs', function () use ( $app ) {
      $jobs = Job::all();
      if ( $jobs ) {
        echo $jobs->to_json();
      } else {
        echo json_encode(array());
      }
  });

  $app->get('/jobs/:id', function ( $id ) use ( $app ) {
    try {
      $job = Job::find($id);
      $owner = User::find($job->owner_id);
      $owner_json = $owner->to_json();
      $response = $job->to_json();
      echo $response = preg_replace('@"owner_id":\d+@', '"owner":'.$owner_json, $response);
    } catch ( ActiveRecord\RecordNotFound $e ) {
      $app->response->setStatus( 404 );
    }
  });

  /**
   * Contact
   */
  $app->get('/contact/:id', function ( $id ) use ( $app ) {
    try {
      $contact = Contact::find($id);
      echo $contact->to_json();
    } catch ( ActiveRecord\RecordNotFound $e ) {
      $app->response->setStatus( 404 );
    }
  });

  /**
   * User
   */
  $app->get('/users/:id', function ( $id ) use ( $app ) {
    try {
      $user = User::find($id);
      echo $user->to_json();
    } catch ( ActiveRecord\RecordNotFound $e ) {
      $app->response->setStatus( 404 );
    }
  });

  $app->run();

