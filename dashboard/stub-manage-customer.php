<?php 
	session_start();

	include("../common/checkconnection.php");
	include("../common/functions.php");
	
	$user_data = check_Login($conn);
	
	print $_SESSION['id'];
	
	// get record related to Cust_ID
	// Let user fill in stuffz
	// Update the customer table/create?
	
	
?>

<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../styles/mystyles.css">
	<script src="../javascript/responsive-nav.js"></script>

</head>
<body>
  <nav>
	<?php print_nav(); ?>
  </nav>
  
  <main>
	<div class="about-us">
		  <h1>WORK IN PROGRESS</h1>
		  <p>Users will be able to put in their user details! like name, phone, email, etc</p>
			<a href="dashboard.php" class="btn">To Dash</a>
	</div>	  
  </main>


  <footer>
	<?php 	
	
		print_footer(); 
	
	?>
  </footer>
</body>
</html>
