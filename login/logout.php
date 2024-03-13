<?php
	session_start();

	if(isset($_SESSION['id']))
	{
		unset($_SESSION['id']);
		unset($_SESSION['info']);
	}

	header("Location: login.php");
	die;
?>