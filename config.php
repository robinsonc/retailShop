<?php

	define('DB_HOST','localhost');
	define('DB_USERNAME','root');
	define('DB_PASSWORD','shoppersstop');
	define('DB_DATABASE','shoppers');

	$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	/* check connection */

	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}


?>
