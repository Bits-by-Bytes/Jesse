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

$userId = $_GET['cust_id'];
$user = getUserById($conn, $userId);

$sqlQuery = "SELECT * FROM `order` WHERE CUST_ID=$userId"; // Escape the reserved keyword 'order'

// Check if a search query parameter is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    // Add search condition to SQL query
    $sqlQuery .= " WHERE FNAME LIKE '%$search%'";
}

// Order by the ORD_DATE column in descending order to get the newest dates first
$sqlQuery .= " ORDER BY ORD_DATE DESC";

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
        <div class="welcomeContainer"><h1>Manage Customer Orders</h1></div>
            <div class="dropdownContainer"><?php print_dropdown($accountType); ?></div>
        </div>

        <a class="btn" href="manage-customer.php">Back to customer list</a><br>

        <h1>Customer: <b><?php echo $user['FNAME']; ?></b></h1>

        <table class="table">
            <tbody>
            <tr>
                <th>First Name:</th>
                <td><?php echo $user['FNAME']; ?></td>
            </tr>
            <tr>
                <th>Last Name:</th>
                <td><?php echo $user['LNAME']; ?></td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td><?php echo $user['PHONE']; ?></td>
            </tr>
            <tr>
                <th>Address:</th>
                <td><?php echo $user['ADDRESS']; ?></td>
            </tr>
            </tbody>
        </table>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>ORD DATE</th>
                <th>STATUS</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($cust = mysqli_fetch_assoc($resultSet)): ?>
                <tr>
                    <td><?php echo $cust['ORDER_ID']; ?></td>
                    <td><?php echo $cust['ORD_DATE']; ?></td>
                    <td><?php echo $cust['STATUS']; ?></td>
                    <td>
                        <a href="manage-order-view.php?cust_id=<?php echo $cust['CUST_ID']; ?>&order_id=<?php echo $cust['ORDER_ID']; ?>&source=manage_customer_view" class="btn-table">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <a class="btn" href="manage-customer.php">Back to customer list</a>
    </div>
</div>

<footer>
    <?php print_footer(); ?>
</footer>

</body>
</html>
