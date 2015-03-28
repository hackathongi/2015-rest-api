<?php
require_once 'vendor/php-activerecord/php-activerecord/ActiveRecord.php';
require_once 'hackjobsUtils.php';

	if ( is_localhost() ) {
		 ActiveRecord\Config::initialize(function($cfg)
		 {
		     $cfg->set_model_directory('models');
		     $cfg->set_connections(array(
		        'development' => 'mysql://u_hackajobs:root@localhost/Hackajobs'));
		 });
	}
	else {
		ActiveRecord\Config::initialize(function($cfg)
		 {
		     $cfg->set_model_directory('models');
		     $cfg->set_connections(array(
		        'development' => 'mysql://hackajob:uiyr683d@mysql/Hackajobs'));
		 });
	}


?>