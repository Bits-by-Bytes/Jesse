<?php		
	session_start();
	
	include("../common/functions.php");
	// will be adding more choices/selection
	// if session info has an id send to confirm
	// else send them to sign up!
	
	
	if (isset($_POST['next'])) {
		
		// puts values all in the info session for later use
		foreach ($_POST as $key => $value)
		{
			$_SESSION['info'][$key] = $value;
		}
		
		$keys = array_keys($_SESSION['info']);
		
		// gets rid of the next value that was set
		if (in_array('next', $keys)) {
			unset($_SESSION['info']['next']);
		}
		
		// to next page
		header("location: confirmation.php");	

		
			
	}
		// for testing purposes of the system
		echo '<pre>';
		print_r ($_SESSION['info']);
		echo '</pre>';
?>

<a href="additional-details.php">Previous</a>

		// If ID session set send to confirmation page
		// if not set send to signup
		
		
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DataTable CSS  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

    <title>Test</title>
</head>

<body>
    <!-- Main Content -->
    <div class="container p-3 my-5 bg-light border border-primary">
        <!-- DataTable Code starts -->
        <table id="example" class="table table-striped nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Location</th>
                    <th>Phone</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tiger</td>
                    <td>Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>t.nixon@datatables.net</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- DataTable JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

    <!-- Custom JS -->
    <script>
		$("#example").DataTable({
		  responsive: true,
		});	
	</script>
</body>

</html>