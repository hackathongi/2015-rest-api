<?php
require_once 'vendor/php-activerecord/php-activerecord/ActiveRecord.php';

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


function is_localhost() {
   $serverList = array('localhost', '127.0.0.1');

	if(!in_array($_SERVER['HTTP_HOST'], $serverList)) {
	        return true;
	}
}


?>