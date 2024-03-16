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

	$user_data = check_Login($conn);

	$sqlQuery = "SELECT * FROM customer";

    // Check if a search query parameter is provided
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
        // Add search condition to SQL query
        $sqlQuery .= " WHERE FNAME LIKE '%$search%'";
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
    <script src="../javascript/responsive-nav.js"></script>
</head>
<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <div class="container">
        <div class="dashboard">
            <div class="header">
                <div class="welcomeContainer"><h1>Manage Customers </h1></div>
                <div class="dropdownContainer"><?php print_dropdown($accountType); ?></div>
            </div>

            <a class="btn" href="../dashboard/dashboard.php">Back to dashboard</a>

            <form method="GET" action="">
                <div class="form-group">
                    <label for="search">Search:</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Enter name">
                    <button type="submit" class="btn-table">Search</button>
                </div>
            </form>

            <table class="table">
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
                    <?php while ($cust = mysqli_fetch_assoc($resultSet)): ?>
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
            <a class="btn" href="../dashboard/dashboard.php">Back to dashboard</a> 
        
        </div>
    </div>

    <footer>
        <?php print_footer(); ?>
    </footer>

    <script src="" async defer></script>
</body>
</html>


