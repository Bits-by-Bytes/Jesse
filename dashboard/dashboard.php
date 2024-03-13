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
    <script src="../javascript/responsive-nav.js"></script>
</head>

<style>
    /*  TODO: Fix this its not working in main css file :(  
	    I think it has to do with confliciting css */
    /*  drop down menu css   */
    #drop {
        position:absolute;
        right:95px;
        z-index: 999;
    }

    ul {
        list-style: none;
        background: #21201d;
        width: 175px;
        border-radius: 4px;
    }

    ul li {
        display: block;
        position: relative;
        border-radius: 15px;
    }

    ul li a {
        display: block;
        padding: 20px 25px;
        color: orange;
        text-decoration: none;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }

    ul li a:hover {
        background: #112C66;
    }

    ul li ul.dropdown {
        width: 100%;
        background: #21201d;
        position: absolute;
        left: -20;
        top: 100%; 
        z-index: 999;
        display: none;
    }

    ul li:hover ul.dropdown {
        display: block;
    }
        /* Styling for dashboard elements */
        .dashboard {
            margin-top: 0px;
            padding: 20px;
            background-color: #e0e0e0;
            border-radius: 10px;
            width: 90%;
            height: 100%;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard form {
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .dashboard .input-group {
            margin-bottom: 20px;
        }

        .dashboard .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .dashboard .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
</style>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
		<!-- Only this one for now might do for others-->
		
	
        <h1 style="position: absolute; top : 25%; left: 3%; fontSize: 60px;">WELCOME:   <?php echo $fname;?> </h1>
        <br><br>
				
        <div class="dashboard">
			
			            	<!-- Only this one for now might do for others-->
		<?php print_dropdown($accountType); ?>
				<?php
					/* TODO: create own css for this page for better look!  */
					// could be put into a function!
					if ($accountType == 'ADMIN') {
						echo '
							<a class="btn btn-primary" class="btn" type="button" href="manage-customer.php"> Manage Customers </a><br>
							<a class="btn btn-primary" class="btn" type="button" href="stub-manage-order.php"> Manage Orders </a><br>
							<a class="btn btn-primary" class="btn" type="button" href="stub-inbox.php"> Inbox </a><br>
						';		
					} else {
						echo '
							<a class="btn btn-primary" class="btn" type="button" href="../selection-tool/furniture-type.php"> Start Request </a><br>
							<a class="btn btn-primary" class="btn" type="button" href="stub-view-order.php"> Manage Orders </a><br>
							<a class="btn btn-primary" class="btn" type="button" href="stub-inbox.php"> Inbox </a><br>
						';
					}
				?>
    

        </div>
    </main>
	


    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>
