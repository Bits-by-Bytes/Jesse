<?php
	// whatever james has
	//$servername = "172.22.2.70";
	//$username = "jesse";
	//$password = "Password1";
	//$database = "projectox";

	// test database
	$servername = "localhost";
	$username = "root";
	$password = "Password1";
	$database = "projectox";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>
