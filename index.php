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
      if ( count($jobs) ) {
        $response = array();
        foreach ( $jobs as $job ) {
          $response[] = json_decode($job->to_json(), true);
        }
        echo json_encode($response);
      } else {
        echo json_encode(array());
      }
  });

  $app->get('/jobs/:id', function ( $id ) use ( $app ) {
    try {
      $job = Job::find($id, array( 'include' => array('owner') ));
      echo $job->to_json(array(
        'include' => array('owner'),
        'except' => 'owner_id'
      ));
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

