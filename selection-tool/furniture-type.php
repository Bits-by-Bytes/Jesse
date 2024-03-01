<?php
	session_start();

	include("../common/checkconnection.php");
	include("../common/functions.php");
	
	if (empty($_POST["guest"])){
		$user_data = check_Login($conn);
	} 

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		// set variable in session?
		
		
		header("Location: test.php");
	}
?>



<!DOCTYPE html>
<html>
	<head>	
		<title>Furniture Select</title>
			<link rel="stylesheet" href="../styles/mystyles.css">
	<link rel="stylesheet" href="../styles/selection-tools.css">
	</head>
	<body>	
	<h1> Hello Hello, <?php print $user_data['EMAIL']; ?> </h1>	
	
	<a href="../login/logout.php"> Log out </a>
	
	    <form method="post">
		
			<ul>
			  <li><input type="checkbox" id="cb1" />
				<label for="cb1"><img src="http://lorempixel.com/100/100" /></label>
			  </li>
			  <li><input type="checkbox" id="cb2" />
				<label for="cb2"><img src="http://lorempixel.com/101/101" /></label>
			  </li>
			  <li><input type="checkbox" id="cb3" />
				<label for="cb3"><img src="http://lorempixel.com/102/102" /></label>
			  </li>
			  <li><input type="checkbox" id="cb4" />
				<label for="cb4"><img src="http://lorempixel.com/103/103" /></label>
			  </li>
			</ul>
			
        <input type="submit" value="submit">
		<form>
	
	</body>
</html>