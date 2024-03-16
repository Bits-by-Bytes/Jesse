<?php
session_start();

include "../common/checkconnection.php";
include "../common/functions.php";

$user_data = check_Login($conn);
$id = $user_data['CUST_ID'];
$accountType = $user_data['ACC_TYPE'];

// Function to get user details by ID
function getUserById($conn, $userId) {
    $query = "SELECT * FROM customer WHERE CUST_ID = '$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result && mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;
}

$userId = isset($_GET['cust_id']) ? $_GET['cust_id'] : null; // Check if cust_id is set in URL
$user = getUserById($conn, $userId);

if ($accountType == 'ADMIN') {
    $sqlQuery = "SELECT c.FNAME, c.LNAME, l.EMAIL, o.* 
    FROM `order` o 
    INNER JOIN customer c ON o.CUST_ID = c.CUST_ID 
    INNER JOIN login l ON c.CUST_ID = l.CUST_ID
    ORDER BY o.ORD_DATE DESC";
} else {
    $sqlQuery = "SELECT c.FNAME, c.LNAME, l.EMAIL, o.* 
    FROM `order` o 
    INNER JOIN customer c ON o.CUST_ID = c.CUST_ID 
    INNER JOIN login l ON c.CUST_ID = l.CUST_ID
    WHERE o.CUST_ID = $id 
    ORDER BY o.ORD_DATE DESC"; // Order by order date in descending order

}



// Execute the SQL query
$resultSet = mysqli_query($conn, $sqlQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="stylesheet" href="../styles/crudstyles.css">
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
    <script src="../javascript/responsive-nav.js" defer></script>
</head>
<body>
<nav>
    <?php print_nav(); ?>
</nav>

<div class="container">
    <div class="dashboard">
        <div class="header">
            <div class="welcomeContainer"><h1>Manage Order</h1></div>
            <div class="dropdownContainer"><?php print_dropdown($accountType); ?></div>
        </div>

        <a class="btn" href="dashboard.php" style="margin-bottom:10px;">Back to dashboard</a>

        <table class="table">
            <thead>
            <tr>
            <?php
                    if ($accountType == "ADMIN"){
                            echo  '            
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            ';
                        }
                    ?>

                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultSet)): ?>
                <!-- Table rows -->
                <tr>
                    <?php
                        if ($accountType == "ADMIN"){
                            echo  '            
                            <td> ' . $row['FNAME']. '</td>
                            <td> ' . $row['LNAME']. '</td>
                            <td> ' . $row['EMAIL']. '</td>
                            ';
                        }
                    ?>

                    <td><?php echo $row['ORDER_ID']; ?></td>
                    <td><?php echo $row['ORD_DATE']; ?></td>
                    <td><?php echo $row['STATUS']; ?></td>
                    <td>
                        <a href="manage-order-view.php?cust_id=<?php echo $row['CUST_ID']; ?>&order_id=<?php echo $row['ORDER_ID']; ?>&source=manage_order" class="btn-table">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a class="btn" href="dashboard.php">Back to dashboard</a>
    </div>
</div>

<footer>
    <?php print_footer(); ?>
</footer>

</body>
</html>
