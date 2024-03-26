<?php 

    // Phone is not working on this page

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

    // Handle form submission for updating information
    if(isset($_POST['update'])) {
        // Retrieve updated information from form
        $new_fname = $_POST['fname'];
        $new_lname = $_POST['lname'];
        $new_phone = $_POST['phone']; 
        $new_email = $_POST['email'];
        $new_address = $_POST['address'];

        // Update customer information in the database
        $update_query = "UPDATE customer SET FNAME='$new_fname', LNAME='$new_lname', PHONE='$new_phone', ADDRESS='$new_address' WHERE CUST_ID='$id'";
        $update_result = mysqli_query($conn, $update_query);

        // Check if update was successful
        if($update_result) {
            // Update email if it has changed
            if($new_email != $email) {
                $update_email_query = "UPDATE login SET EMAIL='$new_email' WHERE CUST_ID='$id'";
                $update_email_result = mysqli_query($conn, $update_email_query);
                if(!$update_email_result) {
                    // Handle error updating email
                    echo "Error updating email: " . mysqli_error($conn);
                    exit();
                }
            }

        } else {
            // Handle error updating customer information
            echo "Error updating information: " . mysqli_error($conn);
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>    
    <title>Change Account Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
    <link rel="icon" type="image/x-icon" href="../images/favi.png">
</head>

<body>
    <nav>
        <?php print_nav(); ?>
        <?php print_navDash($accountType);?>
    </nav>
        
    <main>    
        <div class="container">    
            <div class="dashboard">
                <div class="header">
                    <div class="welcomeContainer"><h1>Welcome   <?php echo $fname;?> </h1></div>
                    <div class="dropdownContainer"><?php print_dropdown($accountType); ?></div>
                </div>

                <form action="change-account-info.php" method="POST">
                    <div class="input-group">
                        <label for="fname">First Name:</label>
                        <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="lname">Last Name:</label>
                        <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" >
                    </div>

                    <!-- may not work not sure why-->
                    <div class="input-group">
                        <label for="phone">Phone:</label> (not working)
                        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" >
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
                    
                    <a class="btn" href="../dashboard/dashboard.php">Back</a>

                    <!-- TODO: Add way to change password! -->
                    <a class="btn" href="../login/change-password.php">Change Password</a>

                    <input class="btn" type="submit" value="Update Information" name="update">
                </form>
                
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>
