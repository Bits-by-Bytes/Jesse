<?php 
    session_start();

    include("../common/checkconnection.php");
    include("../common/functions.php");
    
    // get login for acc_type to display user or admin
    $user_data = check_Login($conn);
    $id = $user_data['CUST_ID'];
    
    // Fetching the customer data based on their CUST_ID
    $query = "SELECT * FROM customer WHERE CUST_ID = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['FNAME'];
        $lname = $row['LNAME'];
        $phone = $row['PHONE'];
        $address = $row['ADDRESS'];
    } else {
        $fname = ''; // handle the case when no data is found
        $lname = '';
        $phone = ''; 
        $address = ''; 
    }
    
    // Fetching the email address of the customer
	// weird database stuff might have to adjust later
    $query1 = "SELECT * FROM login WHERE CUST_ID = '$id' LIMIT 1";
    $result1 = mysqli_query($conn, $query1);

    if ($result1 && mysqli_num_rows($result1) > 0) {
        $row1 = mysqli_fetch_assoc($result1);
		
		// need email for update
        $email = $row1['EMAIL'];
		
		// need for the menu dropdown
		$accountType = $row1['ACC_TYPE']; 
    }

?>


<!DOCTYPE html>
<html>
<head>    
    <title>Change Account Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <style>
        /*  drop down menu css   */
        #drop {
            position: absolute;
            top: 70px; 
            right: 50px; 
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
            left: -20px;
            top: 100%; 
            z-index: 999;
            display: none;
        }

        ul li:hover ul.dropdown {
            display: block;
        }

        /* Styling for dashboard elements */
        .dashboard {
            margin-top: 50px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            width: 70%;
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
</head>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>
        
    <main>    
		<!-- Only this one for now might do for others-->
		<?php print_dropdown($accountType); ?>
        
        <div class="dashboard">
            <h1>Change Account Information</h1>
            <form action="change-account-info.php" method="POST">
                <div class="input-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" required>
                </div>
                <div class="input-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" >
                </div>
				
				<!-- TODO: if they change email they should get reverified? before sending? -->
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>" >
                </div>
                <!-- TODO: Add way to change password! -->
				
				
				<a class="btn" href="../dashboard/dashboard.php">Back out</a>
                <input class="btn" type="submit" value="Update Information" name="update">
            </form>
        </div>
    </main>


    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>

