<?php
session_start();

include("../common/checkconnection.php");
include("../common/functions.php");

// get login for acc_type to display user or admin
// check if it is a valid user in in check_login
// gets id for later if needed
$user_data = check_Login($conn);
$id = $user_data['CUST_ID']; 
$accountType = $user_data['ACC_TYPE']; 

// Get first name for the user
$query = "SELECT FNAME FROM customer WHERE CUST_ID = '$id' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fname = $row['FNAME'];
} else {
    $fname = ''; // handle the case when no data is found
}

$sqlQuery = "SELECT * FROM customer";

// Exclude admin accounts
if ($accountType != 'ADMIN') {
    // Only include customer accounts
    $sqlQuery .= " INNER JOIN login ON customer.CUST_ID = login.CUST_ID WHERE login.ACC_TYPE = 'CUST'";
}

// Checks for any of the switch
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    // Add search condition to SQL query
    $sqlQuery .= " AND FNAME LIKE '%$search%'";
}

// Execute the SQL query
$resultSet = mysqli_query($conn, $sqlQuery);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="stylesheet" href="../styles/crudstyles.css">
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/x-icon" href="../images/favi.png">
    <style>
        /* Adjust the table to take up full width */
        #table_wrapper {
            width: 100%;
            margin: 10px;
        }
        #table {
            width: 100%;
        }
    </style>
</head>

<body>
    <nav>
        <?php print_nav(); ?>
        <?php print_navDash($accountType);?>
    </nav>

    <div class="container">
        <div class="dashboard">
            <div class="header">
                <div class="welcomeContainer"><h1>Manage Customers </h1></div>
                <a class="btn" style="float: right" href="../dashboard/dashboard.php">Back to dashboard</a>
                
            </div>
           
            
            
            <!-- Table setup -->
            <div id="table_wrapper">
                <table id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Last name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cust = mysqli_fetch_assoc($resultSet)): // gets the values related to the customer for admin view?>
                            <tr>
                                <td><?php echo $cust['CUST_ID']; ?></td>
                                <td><?php echo $cust['FNAME']; ?></td>
                                <td><?php echo $cust['LNAME']; ?></td>
                                <td><?php echo $cust['PHONE']; ?></td>
                                <td><?php echo $cust['ADDRESS']; ?></td> 
                                <td>
                                    <a href="manage-customer-view.php?cust_id=<?php echo $cust['CUST_ID'] ?>" class="btn-table">View</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <?php print_footer(); ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
</body>
</html>



