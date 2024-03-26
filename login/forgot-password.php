<?php

session_start();


include("../common/functions.php");

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
            <title>Forget Password</title>
                <?php 
if (isset($_SESSION['started-request'])){
    echo '<a class="btn" style="float: left;" href="../selection-tool/confirmation.php"><</a>';
} else {
    echo '<a class="btn" style="float: left;" href="../selection-tool/index.php">&lt;</a><br>';
}
?><br>

                <h1>Forgot Password</h1>

                    <form method="post" action="send-password-reset.php">

                        <input style="width: 70%;"type="text" name="email" placeholder="Email" required /><br>


                        <a href="signup.php">Sign up</a>&nbsp;&nbsp;&nbsp;
                         <a href="login.php">Login</a><br><br>
                      

                        <button class="btn">Send</button><br><br>
                     
                         <?php
    						
                            if (isset($_SESSION['started-request'])){
                                echo '<a href="../selection-tool/confirmation.php">Back</a>';
                            }
                        
                        ?>
                    </form>
               
				
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>
