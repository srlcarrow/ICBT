<?php

// This is the database connection configuration.
return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=4you_hris_new2',
	'username' => 'root',
	'password' => '1234',
	'charset' => 'utf8',
);

