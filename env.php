<?php

ActiveRecord\Config::initialize(function($cfg) {
  $cfg->set_default_connection( 'production' );
});
