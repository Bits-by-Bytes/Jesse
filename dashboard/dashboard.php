<?php 
    session_start();

    include("../common/checkconnection.php");
    include("../common/functions.php");
    
    // get login for acc_type to display user or admin
    $user_data = check_Login($conn);
    $id = $user_data['CUST_ID']; 
	$accountType = $user_data['ACC_TYPE']; 


    
    // Fetching the first name of the customer based on their CUST_ID
    $query = "SELECT FNAME FROM customer WHERE CUST_ID = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['FNAME'];
    } else {
        $fname = ''; // handle the case when no data is found
    }
?>



<!DOCTYPE html>
<html>
<head>	
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
    <script src="../javascript/responsive-nav.js"></script>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
				
        <div class="container">	
            <div class="dashboard">
                <div class="header">
                    <div class="welcomeContainer"><h1>Welcome   <?php echo $fname;?> </h1></div>
                    <div class="dropdownContainer"><?php print_dropdown($accountType); ?></div>
                </div>
                <div class="left-div">
				<?php
					/* TODO: create own css for this page for better look!  */
					// could be put into a function!
					if ($accountType == 'ADMIN') {
                        
						echo '
							<a  href="manage-customer.php"> Manage Customers </a><br>
							<a  href="manage-order.php"> Manage Orders </a><br>
							<a  href="stub-inbox.php"> Inbox </a><br>
						';
                	
					} else {
						echo '
							<a type="button" href="../selection-tool/furniture-type.php"> Start Request </a><br>
							<a type="button" href="manage-order.php"> Manage Orders </a><br>
							<a type="button" href="stub-inbox.php"> Inbox     </a><br><Br>';
    
					}
				?>
                </div>

                <div class="right-div">
                    <image style="height: 90% ;margin-top: 20px;"src="../images/logos/bearded-ox.png"></image>
                </div>
            </div>
        </div>
                  
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>
