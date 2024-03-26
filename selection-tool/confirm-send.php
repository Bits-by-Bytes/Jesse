<?php
session_start();

include("../common/functions.php");
include("../common/checkconnection.php");
$user_data = check_Login($conn);
$id = $user_data['CUST_ID']; 
$accountType = $user_data['ACC_TYPE']; 

// Function to redirect with stored data
function redirectWithStoredData($storedInfo) {
    // Store data in session
    $_SESSION['stored_info'] = $storedInfo;

    // Unset data in session
    unset($_SESSION['info']);

    // Redirect to furniture-type.php
    header("Location: furniture-type.php");
    exit; // Make sure to exit after redirection
}

// Check if the form is submitted
if(isset($_POST['send-request'])) {
    // Grab the customer ID
    $cust_id = mysqli_real_escape_string($conn, $user_data['CUST_ID']);

    // Construct the SQL query to insert data into the orders table
    $createOrder = "INSERT INTO `order` (CUST_ID, ORD_DATE, STATUS) 
                    VALUES ('$cust_id', NOW(), 'pending')";

    // Execute the SQL query to create an order
    if (mysqli_query($conn, $createOrder)) {
        // Get the ID of the last inserted order
        $order_id = mysqli_insert_id($conn);

        // Extract the stored info
        $storedInfo = $_SESSION['stored_info'];

        // Loop through stored info and insert into tables
        foreach ($storedInfo as $specs) {
            // Extracting values from $specs array
            $furniture_type = isset($specs['furniture-type']) ? mysqli_real_escape_string($conn, $specs['furniture-type']) : "";
            $table_shape_opt = isset($specs['table-shape-opt']) ? mysqli_real_escape_string($conn, $specs['table-shape-opt']) : "";
            $table_base_opt = isset($specs['table-base-opt']) ? mysqli_real_escape_string($conn, $specs['table-base-opt']) : "";
            $wood_type = isset($specs['wood-type']) ? mysqli_real_escape_string($conn, $specs['wood-type']) : "";
            $edge_type = isset($specs['edge-type']) ? mysqli_real_escape_string($conn, $specs['edge-type']) : "";
            $epoxy_option = isset($specs['epoxy-option']) ? mysqli_real_escape_string($conn, $specs['epoxy-option']) : "";
            $epoxy_color = isset($specs['epoxy-color']) ? mysqli_real_escape_string($conn, $specs['epoxy-color']) : "";
            $epoxy_style = isset($specs['epoxy-style']) ? mysqli_real_escape_string($conn, $specs['epoxy-style']) : "";
            $epoxy_type = isset($specs['epoxy-type']) ? mysqli_real_escape_string($conn, $specs['epoxy-type']) : "";
            $length = isset($specs['length']) ? mysqli_real_escape_string($conn, $specs['length']) : "";
            $width = isset($specs['width']) ? mysqli_real_escape_string($conn, $specs['width']) : "";
            $height = isset($specs['height']) ? mysqli_real_escape_string($conn, $specs['height']) : "";
            $additional_details = isset($specs['additional-details']) ? mysqli_real_escape_string($conn, $specs['additional-details']) : "";
        
            // Insert data into the specs table
            $sql_specs = "INSERT INTO specs (FURNI_TYPE, SPECIES, EDGE_TYPE, TABLE_SHAPE, BASE_STYLES, EPOXY_OPTION, EPOXY_COLOR, EPOXY_STYLE, EPOXY_TYPE, LENGTH, WIDTH, HEIGHT, ADD_DETAILS) 
                          VALUES ('$furniture_type', '$wood_type', '$edge_type', '$table_shape_opt', '$table_base_opt', '$epoxy_option', '$epoxy_color', '$epoxy_style', '$epoxy_type', '$length', '$width', '$height', '$additional_details')";
            mysqli_query($conn, $sql_specs);
        
            // Get the auto-generated SPECS_ID from the inserted row
            $specs_id = mysqli_insert_id($conn);
        
            // Insert data into other related tables (assuming you have data to insert)
            // Example: Insert into product table
            $sql_product = "INSERT INTO product (PRICE) VALUES ('0')";
            mysqli_query($conn, $sql_product);
            $prod_id = mysqli_insert_id($conn);
        
            // Insert into prod_order table
            $sql_prod_order = "INSERT INTO prod_order (ORDER_ID, PROD_ID, SPECS_ID) VALUES ('$order_id', '$prod_id', '$specs_id')";
            mysqli_query($conn, $sql_prod_order);
        }

        // request ended
        unset($_SESSION['started-request']);
        // should get rid of
        unset($_SESSION['stored_info']);
        header("Location: success.php");
        exit; // Terminate the script
    } else {
        echo "Error creating order: " . mysqli_error($conn);
    }
}

if (isset($_POST['add_another_item'])) {
    // Store the current item info in the stored_info array
    if (isset($_SESSION['info'])) {
        $_SESSION['stored_info'][] = $_SESSION['info'];
        // Unset the current item info
        unset($_SESSION['info']);
    }
    // Redirect back to furniture-type.php
    header("Location: furniture-type.php");
    exit;
}

// Initialize stored_info as an empty array if not already set or not an array

// lots of AI I have been
// If there's info in the session, store it in the stored_info array
if (isset($_SESSION['info'])) {
    // Append the info from the session to stored_info
    $_SESSION['stored_info'][] = $_SESSION['info'];
    // Unset the current item info
    unset($_SESSION['info']);
}
?>


</html>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/selection-tool.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="icon" type="image/x-icon" href="../images/favi.png">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../javascript/responsive-nav.js"></script>
    <title>Finish Request</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .selection-tool-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #imageUploadContainer img {
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }

        .fa-chevron-down {
            cursor: pointer;
            transition: transform 0.3s;
            transform: rotate(90deg);
        }

        .item-details {
            display: none;
        }

        .open {
            transform: rotate(-2deg);
        }
    </style>
</head>

<body>
<nav>
    <?php 
        print_nav(); 
        print_navTool($accountType); 
     ?>
</nav>

    <main>
        <div class="page-container">
            <div class="header-container">
                <div class="title">
                    <h1>Confirm Request</h1>
                </div>
            </div>
            <div class="selection-tool-container">
                <form method="POST" enctype="multipart/form-data">
                    <h2>Selected Details:</h2>
                    <table class="items-table">
                        <?php
if (isset($_SESSION['stored_info'])) {
    $itemIndex = 0;
    foreach ($_SESSION['stored_info'] as $storedInfo) {
        $furnitureType = isset($storedInfo['furniture-type']) ? $storedInfo['furniture-type'] : 'Furniture'; // Corrected key name to 'furniture-type'
        echo "<tr class='item-row' data-item='$itemIndex'>";
        echo "<td><strong>$furnitureType $itemIndex:</strong> <i class='fa fa-chevron-down'></i></td>";
        echo "</tr>";
        foreach ($storedInfo as $key => $value) {
            $attribute = ucwords(str_replace("-", " ", $key));
            echo "<tr class='item-details' data-item='$itemIndex'>";
            echo "<td><strong>$attribute:</strong></td>";
            echo "<td>";
            if ($key == 'uploaded_files' && is_array($value)) {
                echo "<div id='imageUploadContainer'>";
                foreach ($value as $file) {
                    echo "<img src='{$file}' alt='Uploaded Image'>";
                }
                echo "</div>";
            } else {
                if (is_array($value)) {
                    echo "<select name='item{$itemIndex}_{$key}'>";
                    echo "<option value=''>Select {$attribute}</option>";
                    foreach ($value as $option) {
                        echo "<option value='{$option}'>{$option}</option>";
                    }
                    echo "</select>";
                } else {
                    echo $value;
                }
            }
            echo "</td>";
            echo "</tr>";
        }
        $itemIndex++;
    }
}
?>



                    </table>

                    <div class="nav-controls">
                        <a href="confirmation.php">Previous</a>
                        <input class="btn" type="submit" value="Confirm & Send Request" name="send-request">
                        <input class="btn" type="submit" value="Add Another Item" name="add_another_item">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>

    <script>
        $(document).ready(function() {
            $('.item-row').click(function() {
                var itemIndex = $(this).data('item');
                $(this).find('.fa-chevron-down').toggleClass('open');
                $('.item-details[data-item="' + itemIndex + '"]').toggle();
            });
        });
    </script>
</body>

</html>


