<?php
require_once 'vendor/php-activerecord/php-activerecord/ActiveRecord.php';

		 ActiveRecord\Config::initialize(function($cfg)
		 {
		     $cfg->set_model_directory('models');
		     $cfg->set_connections(array(
		        'development' => 'mysql://u_hackajobs:root@localhost/Hackajobs'));
		 });

?>
