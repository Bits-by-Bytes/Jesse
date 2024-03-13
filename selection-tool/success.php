<?php
	session_start();

	include("../common/checkconnection.php");
	include("../common/functions.php");
 
	$user_data = check_Login($conn);

	header( "refresh:2;url=../dashboard/dashboard.php" );
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
			
			<h1> You have sent a request </h1>
			<h2> Sending you to the dashboard </h2>

			</div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>