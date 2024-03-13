<?php
	
	// IN CONSTRUCTION //
	// Jesse is tired //
	
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
	$resultSet = mysqli_query($conn, $sqlQuery);

?>

</div>
<?php
/*include_once("../common/checkConnection.php");
if ($_POST['action'] == 'edit' && $_POST['id']) {	
	$updateField='';
	if(isset($_POST['FNAME'])) {
		$updateField.= "FNAME='".$_POST['FNAME']."'";
	} else if(isset($_POST['LNAME'])) {
		$updateField.= "LNAME='".$_POST['LNAME']."'";
	} else if(isset($_POST['PHONE'])) {
		$updateField.= "PHONE='".$_POST['PHONE']."'";
	}else if(isset($_POST['ADDRESS'])) {
		$updateField.= "ADDRESS='".$_POST['ADDRESS']."'";
	}
	
	if($updateField && $_POST['CUST_ID']) {
		$sqlQuery = "UPDATE customer SET $updateField WHERE CUST_ID='" . $_POST['CUST_ID'] . "'";	
		mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
		$data = array(
			"message"	=> "Record Updated",	
			"status" => 1
		);
		echo json_encode($data);		
	}
}
if ($_POST['action'] == 'delete' && $_POST['CUST_ID']) {
	$sqlQuery = "DELETE FROM customer WHERE CUST_ID='" . $_POST['CUST_ID'] . "'";	
	mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));	
	$data = array(
		"message"	=> "Record Deleted",	
		"status" => 1
	);
	echo json_encode($data);	
}*/
?>

<!DOCTYPE html>
<html>
<head>	
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/mystyles.css">
    <script src="../javascript/responsive-nav.js"></script>
</head>

<style>
    /*  TODO: Fix this its not working in main css file :(  
	    I think it has to do with confliciting css */
    /*  drop down menu css   */
    #drop {
        position: absolute;
        top: 70px; 
        right: 50px; 
        z-index: 999;
    }

    ul {
        list-style: none;
        background: #21201d;
        width: 175px;
        border-radius: 4px;
    }

    ul li {
        display: block;
        position: relative;
        border-radius: 15px;
    }

    ul li a {
        display: block;
        padding: 20px 25px;
        color: orange;
        text-decoration: none;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }

    ul li a:hover {
        background: #112C66;
    }

    ul li ul.dropdown {
        width: 100%;
        background: #21201d;
        position: absolute;
        left: -20;
        top: 100%; 
        z-index: 999;
        display: none;
    }

    ul li:hover ul.dropdown {
        display: block;
    }
        /* Styling for dashboard elements */
        .dashboard {
            margin-top: 50px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard form {
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .dashboard .input-group {
            margin-bottom: 20px;
        }

        .dashboard .input-group label {
            display: block;
            margin-bottom: 5px;
        }

        .dashboard .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
	 table {
    border-collapse: collapse;
    width: 100%;
    color: #333;
    font-family: Arial, sans-serif;
    font-size: 14px;
    text-align: left;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin: auto;
    margin-top: 50px;
    margin-bottom: 50px;
  } 
  table th {
  background-color: #ff9800;
  color: #fff;
  font-weight: bold;
  padding: 10px;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-top: 1px solid #fff;
  border-bottom: 1px solid #ccc;
}
table td {
  background-color: #fff;
  padding: 10px;
  border-bottom: 1px solid #ccc;
  font-weight: bold;
}
</style>

<body>
    <nav>
        <?php print_nav(); ?>
    </nav>

    <main>
		<!-- Only this one for now might do for others-->
		<?php print_dropdown($accountType); ?>
	
        <h1 style="position: absolute; top : 15%; left: 3%;">Soon to be the CRUD Screen... </h1>
        <br><br>
				
        <div class="dashboard">
				
			
<table id="editableTable" class="table table-bordered">
	<thead>
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Last Name</th>
			<th>Phone</th>
			<th>Address</th>
		
		</tr>
	</thead>
	<tbody>
		<?php while( $cust = mysqli_fetch_assoc($resultSet) ) { ?>
		   <tr id="<?php echo $cust ['CUST_ID']; ?>">
		   <td><?php echo $cust ['CUST_ID']; ?></td>
		   <td><?php echo $cust ['FNAME']; ?></td>
		   <td><?php echo $cust ['LNAME']; ?></td>
		   <td><?php echo $cust ['PHONE']; ?></td>
		   <td><?php echo $cust ['ADDRESS']; ?></td>  		   
		   </tr>
		<?php } ?>
	</tbody>
</table>	
				
			<a class="btn" href="../dashboard/dashboard.php">Back out</a>	
		
        </div>
		
    </main>
	


    <footer>
        <?php print_footer(); ?>
    </footer>
</body>
</html>