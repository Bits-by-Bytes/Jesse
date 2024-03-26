<?php 

	include("../common/functions.php");
	
?>

<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../styles/mystyles.css">
	<script src="../javascript/responsive-nav.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/favi.png">
</head>
<body>
  <nav>
	<?php print_nav(); ?>
  </nav>
  
  <main>
	<div class="about-us">
		  <h1>BITS BY BYTES</h1>
		  <p>Computer Information Technology, Lethbridge College, 2023-2024</p>
		  <p>Alexander Pham, Gradi Mbatika, James Haro, Jesse Van Schothorst, Skyler Black</p>
		  <a href="../selection-tool/index.php" class="btn">To Start</a>
	</div>	  
  </main>


  <footer>
	<?php 	
	
		print_footer(); 
	
	?>
  </footer>
</body>
</html>
