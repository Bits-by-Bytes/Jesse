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

                <h1>Forgot Password</h1>

                    <form method="post" action="send-password-reset.php">

                        <label for="email">email</label>
                        <input type="email" name="email" id="email" required><br><br>



                      

                        <button class="btn">Send</button><br><br>
                        <a href="signup.php">To signup</a>&nbsp;&nbsp;&nbsp;
                         <a href="login.php">To Login</a><br><br>
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
