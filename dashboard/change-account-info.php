<?php
    session_start();

    include("../common/checkconnection.php");
    include("../common/functions.php");

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $id = $_SESSION['id']; // Assuming you have stored user's ID in the session
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        // Update customer information
        $update_query = "UPDATE customer SET FNAME='$fname', LNAME='$lname', ADDRESS='$address' WHERE CUST_ID='$id'";
        $update_result = mysqli_query($conn, $update_query);

        // Update login information (assuming the email can be updated separately)
        $update_login_query = "UPDATE login SET EMAIL='$email' WHERE CUST_ID='$id'";
        $update_login_result = mysqli_query($conn, $update_login_query);

        if ($update_result && $update_login_result) {
	
            // Redirect to a success page or display a success message
            header("Location: account-info-changed.php");
             exit();
        } else {
            // Redirect to an error page or display an error message
			echo "ERROR";
			header( "refresh:3;url=account-information.php" );
            exit();
        }
    } else {
        // Redirect to an error page or display an error message for invalid request
        header("Location: error.php");
        exit();
    }
?>
