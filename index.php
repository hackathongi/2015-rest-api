<?php

  require 'vendor/autoload.php';
  require 'env.php';
  require 'bddConnector.php';

  $app = new \Slim\Slim();

  $app->get('/', function ( ) use ( $app ) {
      echo "Hello HackaJobs";
  });

  /**
   * Jobs API
   */

  // GET /jobs
  $app->get('/jobs', function () use ( $app ) {
      $jobs = Job::all( array( 'include' => array( 'owner' ) ) );
      if ( count($jobs) ) {
        $response = array();
        foreach ( $jobs as $job ) {
          $response[] = json_decode($job->to_json(array(
            'include' => array('owner'),
            'except' => 'owner_id'
          )), true);
        }
        echo json_encode($response);
      } else {
        echo json_encode(array());
      }
  });

  // GET /jobs/:id
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

  // GET /jobs/city/:name
  $app->get('/jobs/city/:name', function ( $name ) use ( $app ) {
      $jobs = Job::find_all_by_city( $name );
      if ( count($jobs) ) {
        $response = array();
        foreach ( $jobs as $job ) {
          $response[] = json_decode($job->to_json(array(
            'include' => array('owner'),
            'except' => 'owner_id'
          )), true);
        }
        echo json_encode($response);
      } else {
        echo json_encode(array());
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

  /**
   * Recommendations
   */
  $app->post('/recommendations', function ( ) use ( $app ) {
    $recommendation = new Recommendation( $app->request()->params() );
    if ( $recommendation->save() ) {
      $app->response->setStatus( 201 );
    } else {
      $app->response->setStatus( 400 );
    }
  });

  /**
   * Applications
   */
  $app->post('/applications', function () use ( $app ) {
    $application = new Application( $app->request()->params() );
    if ( $application->save() ) {
      $app->response->setStatus( 201 );
    } else {
      $app->response->setStatus( 400 );
    }
  });

  $app->run();

