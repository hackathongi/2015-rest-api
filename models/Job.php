<?php
	class Job extends ActiveRecord\Model {
	 	public static $table_name = 'tbl_job';

    static $belongs_to = array(
      array( 'owner', 'class_name' => 'User', 'foreign_key' => 'owner_id' )
    );
	 }
?>
