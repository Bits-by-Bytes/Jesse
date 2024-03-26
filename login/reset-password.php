<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require "../common/database.php";
include("../common/checkconnection.php");
include("../common/functions.php");


$sql = "SELECT * FROM login
        WHERE RESET_TOKEN = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["RESET_TOKEN_EXP"]) <= time()) {
    die("token has expired");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
                <!-- Title -->

        <h1>Reset Password</h1>

        <form method="POST" action="process-reset-password.php">

            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <input type="password" placeholder="New Password" id="password" name="password" required/>

            <input type="password" placeholder="Repeat Password" id="password_confirmation" name="password_confirmation" required/>
            <br>
            <button style="width: 85%" class="btn">Send</button>
        </form>
        </div>
    </div>
    </main>
    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>
