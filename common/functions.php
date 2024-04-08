<?php

// Check if the user is logged in
// Params $conn connect to the database
// for images and link make sure location of file is in folder
function check_login($conn)
{

	if(isset($_SESSION['id']))
	{

		$id = $_SESSION['id'];
		$query = "select * from login where CUST_ID = '$id' limit 1";

		$result = mysqli_query($conn,$query);
		if($result && mysqli_num_rows($result) > 0)
		{
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	Print "Error Need account";
	header("Refresh:3; url=../login/login.php");
	die;

}

// Displays the main nav
// good so we only have to change it in one spot
// for images and link make sure location of file is in folder
function print_nav()
{

	print '
		<div class="topnav" id="myTopnav" >
		
	
		  <a href="https://www.thebeardedox.ca/">HOME</a>
		  <a href="https://www.thebeardedox.ca/who-we-are">WHO WE ARE</a>
		  <a href="https://www.thebeardedox.ca/gallery">GALLERY</a>
		  <a href="https://www.thebeardedox.ca/blog">BLOG</a>
		   

		
	
		  
		  <a href="https://www.thebeardedox.ca/products">PRODUCTS</a>
		  <a href="https://www.thebeardedox.ca/shop">SHOP</a>
		  <a href="https://www.thebeardedox.ca/getintouch">GET IN TOUCH</a>
		 
		  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
		  </a>
		
		  
		</div>

	';
}
// no longer <a href="https://www.thebeardedox.ca/gallery" >GALLERY</a> 
//  <a href="https://www.thebeardedox.ca/getintouch">	CART </a> may be confusing
//<image class="beardedOxLogo"  src="../images/logos/bearded-ox.png"></image> 

function print_navDash($accountType)
{    
    print '<nav class="topnav1" id="myTopnav1">
	<a href="dashboard.php">Dash</a>

                ';

    if ($accountType == "ADMIN") {
        echo '
                    <a href="manage-customer.php">Manage Customers</a>
                    <a href="manage-order.php">Manage Orders</a>
                    <a href="manage-files.php">View Specs</a>';
	} else {
		echo '
			<a href="account-Information.php">Account Information</a>
			<a href="manage-order.php">Manage Orders</a>
		';			
    }


	echo '<script>
		window.onscroll = function() {myFunction()};

		var navbar = document.getElementById("myTopnav1");
		var sticky = navbar.offsetTop;

		function myFunction() {
		if (window.pageYOffset >= sticky) {
			navbar.classList.add("sticky")
		} else {
			navbar.classList.remove("sticky");
		}
		}
		</script>';
        
}


function print_navTool($accountType)
{    
    print '<nav class="topnav1" id="myTopnav1">
	

                ';

				if ($accountType == "ADMIN") {
					echo '
					<a href="../dashboard/dashboard.php">Dash</a>
								<a href="../dashboard/manage-customer.php">Manage Customers</a>
								<a href="../dashboard/manage-order.php">Manage Orders</a>
								<a href="../dashboard/manage-files.php">Manage Tool</a>';
				} elseif ($accountType == "selection"){
echo "You are not signed in";
				} else {
					echo '
					<a href="../dashboard/dashboard.php">Dash</a>
					<a href="../dashboard/account-Information.php">Account Information</a>
					<a href="../dashboard/manage-order.php">Manage Orders</a>
					';			
				}


			// for the sticky nav!	got from w3
	echo '<script>
	window.onscroll = function() {myFunction()};

	var myTopnav1 = document.getElementById("myTopnav1");
	var sticky = myTopnav1.offsetTop;

	function myFunction() {
	if (window.pageYOffset >= sticky) {
		myTopnav1.classList.add("sticky")
	} else {
		myTopnav1.classList.remove("sticky");
	}
	}
	</script>';
        
}






// Displays the footer
// good so we only have to change it in one spot
function print_footer()
{
	echo '  
	  
		<div class="footer">
		  <div class="footer-content">
			<p class="bold-footer">Let’s Build Beautiful Things Together</p>
			
			<!-- Might change to our login page? -->
			<a href="../selection-tool/furniture-type.php" class="btn">Start Now</a>
			
		  </div>
		  <div class="socials">
			<a href="https://www.instagram.com/beardedoxtimber/"><i class="fa fa-instagram"></i> Instagram</a>
			<a href="https://www.facebook.com/beardedoxtimber/"><i class="fa fa-facebook"></i> Facebook</a>
		  </div>
		  <div class="bottom-footer-container">
			<div class="left-footer">
			  
			  <p>©2021 The Bearded Ox Timber Co.</p><p> ALL RIGHTS RESERVED - <a href="https://www.thebeardedox.ca/legal" >LEGAL</a></p>
			  <p> Bits by Bytes - <a href="../dashboard/bitbybytes.php">About Us</a></p>
			</div>
			<div class="middle-footer">
			  <image src="../images/logos/bearded-ox-timber.png
			  
			  "></image>
			</div>
			<div class="right-footer">
			  <p>Custom Built furniture - Custom Milled Lumber</p>
			  <p>The Bearded Ox</p>
			  <p>116 Kenyon Drive, Lethbridge, Alberta, T1K7N3</p>
			</div>
		  </div>
		</div>
		
		';
}

function print_footer1()
{
	echo '  
	  
		<div class="footer">
		  <div class="footer-content">
			<p class="bold-footer">Let’s Build Beautiful Things Together</p>
			
			<!-- Might change to our login page? -->
			
		  </div>
		  <div class="socials">
			<a href="https://www.instagram.com/beardedoxtimber/"><i class="fa fa-instagram"></i> Instagram</a>
			<a href="https://www.facebook.com/beardedoxtimber/"><i class="fa fa-facebook"></i> Facebook</a>
		  </div>
		  <div class="bottom-footer-container">
			<div class="left-footer">
			  
			  <p>©2021 The Bearded Ox Timber Co.</p><p> ALL RIGHTS RESERVED - <a href="https://www.thebeardedox.ca/legal" >LEGAL</a></p>
			  <p> Bits by Bytes - <a href="../dashboard/bitbybytes.php">About Us</a></p>
			</div>
			<div class="middle-footer">
			  <image src="../images/logos/bearded-ox-timber.png
			  
			  "></image>
			</div>
			<div class="right-footer">
			  <p>Custom Built furniture - Custom Milled Lumber</p>
			  <p>The Bearded Ox</p>
			  <p>116 Kenyon Drive, Lethbridge, Alberta, T1K7N3</p>
			</div>
		  </div>
		</div>
		
		';
}


// logout function (lazy)
function print_dropdown($accountType)
{
echo '

<div class="dropdown" style="float:right;">
	<a href="../login/logout.php" class="dropbtn">Logout</a>;	
</div>

';

}
//<a href=\"stub-manage-customer.php\">Inbox</a>
//<a href=\"stub-inbox.php\">Inbox</a>

function exit_selection() 
{
    if (isset($_POST['return'])) {
        // Unset session data on exit
        unset($_SESSION['request-start']);
        unset($_SESSION['info']);
		unset($_SESSION['stored_info']);

        if (isset($_SESSION['id'])) {
            // If the user is logged in, redirect to the dashboard
            header("location: ../dashboard/dashboard.php");
        } else {
            // If not logged in, redirect to the index (home) page
            header("location: index.php");
        }
        
        exit(); // Exit the script to prevent further execution
    }


	
	if (isset($_SESSION['id'])) {
		// If the user is logged in, redirect to the dashboard
		echo 
		"
		<form method='post' action=''>
			<button class='btn' type='submit' name='return'>Return to Dash</button>
		</form>
		";
	} else {
		// If not logged in, redirect to the index (home) page
		echo 
		"
		<form method='post' action=''>
			<button class='btn' type='submit' name='return'>Return to Start</button>
		</form>
		";
	}
}



?>