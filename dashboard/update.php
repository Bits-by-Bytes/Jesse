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

function getImagesBySpecsId($conn, $specs_id) {
    $images = array();

    // Prepare and execute SQL query
    $query = "SELECT * FROM `images` WHERE SPECS_ID = '$specs_id'";
    $result = mysqli_query($conn, $query);

    // Fetch associative array of images
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row;
        }
        mysqli_free_result($result);
    } else {
        echo "Error retrieving images: " . mysqli_error($conn);
    }

    return $images;
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
$userId = isset($_GET['cust_id']) ? $_GET['cust_id'] : null;
$user = null;

if ($userId !== null) {
    $user = getUserById($conn, $userId);
    if ($user === null) {
        // Handle the case where user data is not found
        echo "User data not found.";
    }
} else {
    // Handle the case where cust_id is not provided
    echo "Customer ID is not provided.";
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if orderId is set
    $orderId = isset($_GET['order_id']) ? $_GET['order_id'] : null;

    if ($orderId) {
        // Sanitize input to prevent SQL injection
        $newStatus = mysqli_real_escape_string($conn, $_POST['status']);
        
        // Prepare and execute SQL update statement
        $updateQuery = "UPDATE `ORDER` SET STATUS = '$newStatus' WHERE ORDER_ID = '$orderId'";
        $result = mysqli_query($conn, $updateQuery);

        // Check for errors
        if (!$result) {
            // Handle error
            die("Error updating order status: " . mysqli_error($conn));
        }

        // Get userId
        $userId = isset($_POST['cust_id']) ? $_POST['cust_id'] : null;

        // Determine the source
        $source = isset($_POST['source']) ? $_POST['source'] : '';

        if ($source === 'manage_order') {
            // If the user came from manage-order, set the back link accordingly
            $back_link = 'manage-order.php';
        } elseif ($source === 'manage_customer_view' && $userId) {
            // If the user came from manage-customer-view, set the back link accordingly
            $back_link = "manage-customer-view.php?cust_id=$userId";
        } else {
            // Default back link if source is not specified or invalid
            $back_link = 'manage-order.php';
        }

        // Redirect user to the appropriate page
        header("Location: $back_link");
        exit();
    } else {
        // Handle case where orderId is not set
        die("Error: Order ID is not set.");
    }
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
    <link rel="icon" type="image/x-icon" href="../images/favi.png">

    <style>
        .export-button-container {
            text-align: right;
            margin-bottom: 10px;
        }
        /* CSS to style images */
.image-container {
    margin-top: 10px;
}

.image-container img {
    max-width: 200px; /* Set maximum width for the images */
    height: auto; /* Maintain aspect ratio */
    margin-right: 10px; /* Add some space between images */
}
.form-container {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style for label */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* Style for select dropdown */
        select {
            width: 50%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="18px" height="18px"><path d="M7 10l5 5 5-5H7z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
            font-size: 16px;
            line-height: 1.5;
            outline: none;
            cursor: pointer;
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
            <div class="welcomeContainer"><h1>Manage Order</h1></div>
            <a href="<?php echo $back_link; ?>" class="btn">Back</a>        </div>
        <h1>Customer: <b><?php echo $user !== null ? $user['FNAME'] : "Unknown" ?></b></h1>

   
       
                
          
            <table class="table">
                <tbody>
                    <tr>
                        <th>Order ID:</th>
                        <td><?php echo $order['ORDER_ID'] ?></td>
                    </tr>
                    <tr>
                        <th>Order Date:</th>
                        <td><?php echo $order['ORD_DATE']?>
                    </tr>
                    <tr>
                 
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?cust_id=' . $userId . '&order_id=' . $orderId . '&source=manage_order'; ?>">
                       <th> <label for="status">Update Status:</label> </th>
                       <td><select name="status" id="status">
                            <option value="Pending" <?php if ($order['STATUS'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Processing" <?php if ($order['STATUS'] == 'Processing') echo 'selected'; ?>>Processing</option>
                            <option value="Building" <?php if ($order['STATUS'] == 'Building') echo 'selected'; ?>>Building</option>
                            <option value="Finished" <?php if ($order['STATUS'] == 'Finished') echo 'selected'; ?>>Finished</option>
                        </select>
                        <button type="submit" class="btn">Update</button></td>
                    </form>

            
        </table>

    
        <?php if (!empty($productOrders)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Specs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productOrders as $prodOrder): ?>
                        <tr>
                            <td>
                         
                            <?php
                                $specs = getSpecsById($conn, $prodOrder['SPECS_ID']);
                                if ($specs) {
                                    echo "Furniture Type: " . htmlspecialchars($specs['FURNI_TYPE']) . "<br>";
                                    echo "Table Shape: " . htmlspecialchars($specs['TABLE_SHAPE']) . "<br>";
                                    echo "Table Base: " . htmlspecialchars($specs['BASE_STYLES']) . "<br>";
                                    echo "Wood Type: " . htmlspecialchars($specs['SPECIES']) . "<br>";
                                    echo "Edge Type: " . htmlspecialchars($specs['EDGE_TYPE']) . "<br>";
                                    echo "Epoxy Option: " . htmlspecialchars($specs['EPOXY_OPTION']) . "<br>";
                                    echo "Epoxy Color: " . htmlspecialchars($specs['EPOXY_COLOR']) . "<br>";
                                    echo "Epoxy Style: " . htmlspecialchars($specs['EPOXY_STYLE']) . "<br>";
                                    echo "Epoxy Type: " . htmlspecialchars($specs['EPOXY_TYPE']) . "<br>";
                                    echo "Length: " . htmlspecialchars($specs['LENGTH']) . "<br>";
                                    echo "Width: " . htmlspecialchars($specs['WIDTH']) . "<br>";
                                    echo "Height: " . htmlspecialchars($specs['HEIGHT']) . "<br>";
                                    echo "Additional Details: " . htmlspecialchars($specs['ADD_DETAILS']) . "<br>";

                                    // Display associated images
                                    $images = getImagesBySpecsId($conn, $specs['SPECS_ID']);
                                    if ($images) {
                                        echo "<div class='image-container'>";
                                        foreach ($images as $image) {
                                            echo "<img src='" . htmlspecialchars($image['IMG_PATH']) . "' alt='Associated Image'>";
                                        }
                                        echo "</div>";
                                    }
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
   
        
</div>
</div>
<footer>
<?php print_footer(); ?>
</footer>
<script src="" async defer></script>
</body>
</html>

