<?php


	// Include functions and checkconnection.php
	include("../common/checkconnection.php");
	include("../common/functions.php");

	$errCount = 0;

	if ($_SERVER['REQUEST_METHOD'] == "POST") {

			// Redirect login to the appropriate page
			header("Location: ../dashboard/dashboard.php");
			exit; // Ensure no further code execution after redirection
	}
	
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
                <h1> Reset your password </h1>
                
				<?php
					// Validate selector and validator values
					$token = $_GET['token'];
					$token_hash = hash("sha256", $token);
					
					// Require the checkconnection.php file
					$mysqli = require '../common/checkConnection.php';
					
					if (!isset($conn)) {
						die("Failed to establish database connection");
					}
										
					$sql = "SELECT * FROM login
					        WHERE RESET_TOKEN = ?";
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bind_param("s", $token_hash);
					
					$stmt->execute();
					
					$result = $stmt->get_result();
					
					$login = $result->fetch_assoc();
					
					if ($login == null) {
						echo "SQL: $sql<br>";
						echo "Token: $token_hash<br>";
						echo "Token: $token<br>";
					    die("Token not found");
						
					}
					
					if (strtotime($login["RESET_TOKEN_EXP"]) <= time()) {
					    die("Token has expired");
					}
				?>
				
				<form method="post" action="proc-reset-pass.php">
				    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

				    <label for="password">New password</label>
				    <input type="password" id="password" name="password" required>
				    <label for="password_confirmation">Repeat password</label>
				    <input type="password" id="password_confirmation" name="password_confirmation" required>
				    <button>Reset Password</button>
				</form>
			</div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>
