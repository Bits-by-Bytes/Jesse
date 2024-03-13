<?php
	session_start();

	include("../common/functions.php");
	include("../common/checkconnection.php");

	$user_data = check_Login($conn);

	// grab just in case they go back so they don't have to log in again
	$_SESSION['id'] = $user_data['CUST_ID'];

	if (isset($_POST['send-request'])) {
		// Escape user inputs to prevent SQL injection
		$cust_id = mysqli_real_escape_string($conn, $user_data['CUST_ID']);
		
		// Construct the SQL query to insert data into the orders table
		$createOrder = "INSERT INTO `order` (CUST_ID, ORD_DATE, STATUS) 
						VALUES ('$cust_id', NOW(), 'pending')";

		// Execute the SQL query to create an order
		if (mysqli_query($conn, $createOrder)) {
			// Get the ID of the last inserted order
			$order_id = mysqli_insert_id($conn);

			// Create a product
			$createProduct = "INSERT INTO `product` (price) VALUES ('0')";
			if (mysqli_query($conn, $createProduct)) {
				// Get the ID of the last inserted product
				$product_id = mysqli_insert_id($conn);

				// Prepare the column names and values for the SQL query for specs
				$info_keys = array(
					'furniture-type',
					'wood-type',
					'table-shape-opt',
					'edge-type',
					'epoxy-option',
					'epoxy-style',
					'epoxy-foggy',
					'epoxy-color',
					'additional-details'
				);
				$info = array();
				foreach ($info_keys as $key) {
					$info[$key] = isset($_SESSION['info'][$key]) ? mysqli_real_escape_string($conn, $_SESSION['info'][$key]) : null;
				}
				$columns = implode(", ", array_keys($info));
				$values = "'" . implode("', '", $info) . "'";

				// Construct the SQL query to insert data into the specs table
				$insert_specs_query = "INSERT INTO specs (FURNI_TYPE, SPECIES, LIVE_EDGE, BASE_STYLES, 
														  EPOXY_OPTION, EPOXY_STYLE, EPOXY_TYPE, EPOXY_COLOR, ADD_DETAILS)
									   VALUES ($values)";

				// Execute the SQL query to insert data into the specs table
				if (mysqli_query($conn, $insert_specs_query)) {
					// Get the ID of the last inserted specs
					$specs_id = mysqli_insert_id($conn);

					// Construct the SQL query to insert data into the prod_order table
					$createProductOrder = "INSERT INTO prod_order (ORDER_ID, PROD_ID, SPECS_ID) 
											VALUES ('$order_id', '$product_id', '$specs_id')";

					// Execute the SQL query to insert data into the prod_order table
					if (mysqli_query($conn, $createProductOrder)) {
						// Query executed successfully
						
							// request ended
							unset($_SESSION['started-request']);
							// should get rid of
							unset($_SESSION['info']);
							header("Location: success.php");
							die;
						
						
					} else {
						// Query failed
						// Handle the error, display an error message, or perform any necessary actions
						echo "Error: " . mysqli_error($conn);
					}
				} else {
					// Query failed
					// Handle the error, display an error message, or perform any necessary actions
					echo "Error: " . mysqli_error($conn);
				}
			} else {
				// Query failed
				// Handle the error, display an error message, or perform any necessary actions
				echo "Error: " . mysqli_error($conn);
			}
		} else {
			// Query failed
			// Handle the error, display an error message, or perform any necessary actions
			echo "Error: " . mysqli_error($conn);
		}
	}

	// tottaly no ai here :) just pain and suffering
?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/selection-tool.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <script src="../javascript/responsive-nav.js"></script>
    <title>Finish Request</title>
</head>
<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
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


    </style>
<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
        <div class="page-container">
            <div class="header-container">
                <div class="title">
                    <h1>Send Request</h1>
                </div>
            </div>
            <div class="selection-tool-container">
                <form method="POST" enctype="multipart/form-data">
                    <?php
					
					// todo add better layout
					// add way to allow for multiple options
					// cry
                    echo "<h2>Selected Details:</h2>";
                    echo "<table>";
                    foreach ($_SESSION['info'] as $key => $value) {
                        $attribute = ucwords(str_replace("-", " ", $key));
                        echo "<tr>";
                        echo "<td><strong>$attribute:</strong></td>";
                        echo "<td>$value</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>

                    <div class="nav-controls">
                        <a href="confirmation.php">Previous</a>
                        <input class="btn" type="submit" value="Send Request" name="send-request">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <?php print_footer(); ?>
    </footer>
</body>

</html>
