<?php
session_start();

include("../common/checkconnection.php");
include("../common/functions.php");

// Function to get order details by order ID
function getOrderById($conn, $orderId) {
    $query = "SELECT * FROM `ORDER` WHERE ORDER_ID = '$orderId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Function to get product orders by order ID
function getProductOrdersByOrderId($conn, $orderId) {
    $query = "SELECT * FROM PROD_ORDER WHERE ORDER_ID = '$orderId'";
    $result = mysqli_query($conn, $query);
    $productOrders = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $productOrders[] = $row;
        }
    }
    return $productOrders;
}

// Function to get specs by specs ID
function getSpecsById($conn, $specsId) {
    $query = "SELECT * FROM SPECS WHERE SPECS_ID = '$specsId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Check if user is logged in and get user data
$user_data = check_Login($conn);
$id = $user_data['CUST_ID']; 
$accountType = $user_data['ACC_TYPE']; 

// Sanitize input to prevent SQL injection
$orderId = isset($_GET['order_id']) ? mysqli_real_escape_string($conn, $_GET['order_id']) : null;

// Get order details
$order = getOrderById($conn, $orderId);

// Get product orders for the order
$productOrders = getProductOrdersByOrderId($conn, $orderId);

// Function to get user by ID
function getUserById($conn, $userId) {
    $query = "SELECT * FROM customer WHERE CUST_ID = '$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Get user by ID from URL
$userId = $_GET['cust_id'];
$user = getUserById($conn, $userId);


$source = isset($_GET['source']) ? $_GET['source'] : '';

if ($source === 'manage_order') {
    // If the user came from manage-order, set the back link accordingly
    $back_link = 'manage-order.php';
} elseif ($source === 'manage_customer_view') {
    // If the user came from manage-customer-view, set the back link accordingly
    $back_link = "manage-customer-view.php?cust_id=$userId";
} else {
    // Default back link if source is not specified or invalid
    $back_link = 'manage-order.php';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="stylesheet" href="../styles/crudstyles.css">
    <link rel="stylesheet" href="../styles/dashboardStyles.css">
    <style>
        .export-button-container {
            text-align: right;
            margin-bottom: 10px;
        }
    </style>
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
        <a href="<?php echo $back_link; ?>" class="btn">Back</a>
        <div class="export-button-container">
            <a href="export.php?id=<?php echo $orderId; ?>" class="btn btn-primary">Export</a>
        </div>
   
       
                <h1>Customer: <b><?php echo $user['FNAME'] ?></b></h1>
          
            <table class="table">
                <tbody>
                    <tr>
                        <th>Order ID:</th>
                        <td><?php echo $order['ORDER_ID'] ?></td>
                    </tr>
                    <tr>
                        <th>Order Date:</th>
                        <td><?php echo $order['ORD_DATE']?></td>
                    </tr>
                    <tr>
                        <th>Order Status:</th>
                        <td><?php echo $order['STATUS']?></td>
                    </tr>
                </tbody>
            </table>

        
            <?php if (!empty($productOrders)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Specs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productOrders as $prodOrder): ?>
                            <tr>
                                <td><?php echo $prodOrder['PROD_ID']; ?></td>
                                <td>
                                    <?php
                                    $specs = getSpecsById($conn, $prodOrder['SPECS_ID']);
                                    if ($specs) {
                                        echo "Furniture Type: " . $specs['FURNI_TYPE'] . "<br>";
                                        echo "Species: " . $specs['SPECIES'] . "<br>";
                                        echo "Live Edge: " . $specs['LIVE_EDGE'] . "<br>";
                                        echo "Base Styles: " . $specs['BASE_STYLES'] . "<br>";
                                        echo "Epoxy Option: " . $specs['EPOXY_OPTION'] . "<br>";
                                        echo "Epoxy Style: " . $specs['EPOXY_STYLE'] . "<br>";
                                        echo "Epoxy Type: " . $specs['EPOXY_TYPE'] . "<br>";
                                        echo "Epoxy Color: " . $specs['EPOXY_COLOR'] . "<br>";
                                        echo "Additional Details: " . $specs['ADD_DETAILS'] . "<br>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No product Details found for this order</p>
            <?php endif; ?>
       
            <a href="<?php echo $back_link; ?>" class="btn">Back</a>
    </div>
</div>
<footer>
    <?php print_footer(); ?>
</footer>
<script src="" async defer></script>
</body>
</html>
