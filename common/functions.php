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

// Displays the nav
// good so we only have to change it in one spot
// for images and link make sure location of file is in folder
function print_nav()
{

	print '
		<div class="topnav" id="myTopnav" >
		
	
		  <a href="https://www.thebeardedox.ca/">HOME</a>
		  <a href="https://www.thebeardedox.ca/who-we-are">WHO WE ARE</a>
		  <a href="https://www.thebeardedox.ca/blog">BLOG</a>
		  <a href="https://www.thebeardedox.ca/gallery" >GALLERY</a>

		
		  <image class="beardedOxLogo"  src="../images/logos/bearded-ox.png"></image>
	
		  
		  <a href="https://www.thebeardedox.ca/products">PRODUCTS</a>
		  <a href="https://www.thebeardedox.ca/shop">SHOP</a>
		  <a href="https://www.thebeardedox.ca/getintouch">GET IN TOUCH</a>
		  <a href="https://www.thebeardedox.ca/getintouch">	CART </a>
		  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
			<i class="fa fa-bars"></i>
		  </a>
		
		  
		</div>

	';
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
			<a href="https://www.thebeardedox.ca/getintouch" class="btn">Start Now</a>
			
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



function print_dropdown($accountType)
{
	echo '  
		<div id="drop">
			<ul>
				<li>
					<a href="#"> MENU </a>
					<ul class="dropdown">';
					
	if ($accountType == "ADMIN") {
		echo "
			<li><a href=\"manage-customer.php\">Manage Customers</a></li>
			<li><a href=\"stub-manage-order.php\">Manage Orders</a></li>
			<li><a href=\"stub-manage-customer.php\">Inbox</a></li>
		";      
	} else {
		echo "
			<li><a href=\"account-Information.php\">Account Information</a></li>
			<li><a href=\"stub-manage-order.php\">Manage Orders</a></li>
			<li><a href=\"stub-inbox.php\">Inbox</a></li>
		";
	}
					
	echo '
						<!-- Files might have to be renamed for better clarity but later -->
						<li><a href="../login/logout.php">Log out</a></li>
					</ul>
				</li>
			</ul>
		</div>';
}
?>