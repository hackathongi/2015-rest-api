<?php
	class User extends ActiveRecord\Model {
	 	public static $table_name = 'tbl_user';

    static $has_many = array(
      array( 'jobs' )
    );
	 }
?>
