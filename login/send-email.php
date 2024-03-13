<?php
	session_start();

	// for the nav
	include("../common/functions.php");

	
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
        <div class="login-container">
            <div class="login-form">
			<h1> Reset Your Password </h1>
			<form action='stub-password-reset.php' method='post'>
			
				<input type='text' name='email' placeholder='enter email' required>
				<?php 
				if(isset($_GET['reset'])) {
					if ($_GET['reset'] == 'success') {
						echo 'Check your email!<br>';
					}
				}
				
				?>
				
				
			<form>
			<a href="../login/login.php" class="btn">back to login</a>
			<a href="stub-password-reset.php" class="btn">Send Link</a><br>
			</div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>