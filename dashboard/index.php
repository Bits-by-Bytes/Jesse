<?php 

	session_start();

	include("../common/checkconnection.php");
	include("../common/functions.php");
	
	$user_data = check_Login($conn);
	
	// if admin display admin stuff and carry admin flag??
	// if user display user stuff
	// if guest no

?>


<!DOCTYPE html>
<html>
	<head>	
		<title>Login</title>
		<link rel="stylesheet" href="styles/mystyles.css">
	</head>

	<body>		
	

	<a href="../login/login.php"> Log out </a>
	
	<h1> Hello Hello, <?php print $user_data['EMAIL']; ?> </h1>
	<a href="../selection-tool/furniture_type.php"> Start Request </a>


	</body>
</html>