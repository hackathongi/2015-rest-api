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
          if ( empty($job) ) continue;
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
  $app->get('/contacts/:id', function ( $id ) use ( $app ) {
    try {
      $contact = Contact::find($id);
      echo $contact->to_json();
    } catch ( ActiveRecord\RecordNotFound $e ) {
      $app->response->setStatus( 404 );
    }
  });

  $app->post('/contacts', function () use ( $app ) {
    $contact = new Contact( $app->request()->params() );
    if ( $contact->save() ) {
      $app->response->setStatus( 201 );
    } else {
      $app->response->setStatus( 400 );
    }
  });

  $app->post('/user_to_contact', function () use ( $app ) {
    $user_id = $app->request()->params('user_id');
    $friend_id = $app->request()->params('friend_id');

    $user = User::find( $user_id );

    $contact = new Contact( array(
      'id'      => $user_id,
      'user_id' => $friend_id,
      'name'    => $user->name,
      'facebook_id' => $user->facebook_id,
      'picture_url' => "https://graph.facebook.com/{$user->facebook_id}/picture?type=large"
    ) );

    if ( $contact->save() ) {
      $app->response->setStatus( 201 );
    } else {
      $app->response->setStatus( 400 );
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

  /**
   * Nearby Jobs
   */
  // GET /nearby
  // longitude
  // latitude
  $app->get('/nearby', function () use ( $app ) {
    $latitude = $app->request()->params('latitude');
    $longitude = $app->request()->params('longitude');

    // 6371 means search by km
    $query = "SELECT id, ( 6371 * acos( cos( radians({$latitude}) ) * cos(
    radians( latitude ) ) * cos( radians( longitude ) - radians({$longitude}) ) +
    sin( radians({$latitude}) ) * sin( radians( latitude ) ) ) )
    AS distance
    FROM tbl_job
    HAVING distance < 25
    ORDER BY distance
    LIMIT 0 , 20;";

    $matches = Job::find_by_sql( $query );
    if ( count($matches) ) {
      $response = array();
      foreach ( $matches as $match ) {
        $job = Job::find($match->id);
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

  $app->run();

