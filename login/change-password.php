<?php

session_start();


include("../common/functions.php");
include("../common/checkconnection.php");

        // get login for acc_type to display user or admin
        if (isset($_SESSION['id'])) {
            $user_data = check_Login($conn);
            $id = $user_data['CUST_ID']; 
            $accountType = $user_data['ACC_TYPE']; 
        } else {
            $accountType = "selection";
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
    <?php 
        print_nav(); 
        print_navTool($accountType); 
     ?>
</nav>

    <main>
        <div class="login-container">
		
            <div class="login-form">		
            <title>Password Change</title>
                <?php 
if (isset($_SESSION['started-request'])){
    echo '<a class="btn" style="float: left;" href="../dashboard/account-information.php"><</a>';
} else {
    echo '<a class="btn" style="float: left;" href="../dashboard/account-information.php">&lt;</a><br>';
}
?><br>

                <h1>Change Password</h1>

                    <form method="post" action="send-password-reset.php">

                        <input style="width: 70%;"type="text" name="email" placeholder="Email" required /><br>
                      
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
