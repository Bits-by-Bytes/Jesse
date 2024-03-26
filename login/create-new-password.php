<?php
	session_start();

	// for the nav
	include("../common/functions.php");
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$passwordVerify = mysqli_real_escape_string($conn, $_POST['passwordVerify']);
			
			$check = "SELECT * FROM login WHERE email = '$email' LIMIT 1";
			$result = mysqli_query($conn, $check);
			
			// All the password stuff
			// validates strong password https://www.codexworld.com/how-to/validate-password-strength-in-php/
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$number    = preg_match('@[0-9]@', $password);
			$specialChars = preg_match('@[^\w]@', $password);
			
			
			// first error checks
			if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
				echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
				$errCount += 1;
			} elseif ($passwordVerify !== $password) { // if the password verify and password does not match
				echo 'Passwords do not match!';
				$errCount += 1;
			} 
			
			
			// if no errors (valid inputs then hash password and send to database)
			if ($errCount !== 0) { 
				// Once email sends 
				header("Location: login.php");
				die;
			}

	}
?>	

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
	<link rel="icon" type="image/x-icon" href="../images/favi.png">

    <script src="../javascript/responsive-nav.js"></script>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="login-container">
            <div class="login-form">
			<h1> Reset your password </h1>
			<title>Password Reset</title>

			<?php // how the video had it	
				$selector = $_GET['selector'];
				$validator = $_GET['validator'];
				
				if (empty($validator) || empty($selector)){
					echo 'Could not validate!';
				} else {
					if(ctype_xdigit($selector) !== false
							&& ctype_xdigit($validator) !== false) {
				?>
				
					<form action="reset-request" method="POST">
						<input type="hidden" name="selector" value='<?php echo $selector; ?>' required>
						<input type="hidden" name="validator"  value='<?php echo $validator; ?>'>
						<input type='password' name='password' placeholder='Enter new password'>
						<input type='password' name='passwordVerify' placeholder='Enter new password again'>
					 
						<input type="submit" name="reset-request" value="Send Link By Email" class="btn">
					</form>
			<?php
				}
			}
			?>
			
			</div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>