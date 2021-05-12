
<?php 
	if(isset($_GET["userid"])){

		Session::destroy(); 
	}
?>

<div>
   	  <div>	
	     <div class="container-fluid  bg-light text-dark" id="style">
			<div class="row">
                <div class="col-sm">
					<h4>Information</h4>
					<ul>
					<li><a class="text-dark" href="about.php">About Us</a></li>
					<li><a class="text-dark" href="contactus.php">Customer Service</a></li>
					<li><a class="text-dark" href="contactus.php"><span>Contact Us</span></a></li>
					</ul>
				</div>
				<div class="col-sm text-dark">
					<h4>My account</h4>
					<ul>
						<?php 
							if(!(Session::get("userLogin"))){
						?>
						<li><a class="text-dark" href="login.php">Sign In</a></li>
						<?php } else{?>
							<li><a class="text-dark" href="?userid=<?php Session::get('userId');?>">Sign out</a></li>
							<li><a class="text-dark" href="profile.php">Profile</a></li>
							<li><a class="text-dark" href="watchlist.php">My Watchlist</a></li>
							<li><a class="text-dark" href="wishlist.php">My Watchlater</a></li>
						<?php }?>
						<li><a class="text-dark" href="contactus.php">Help</a></li>
				    </ul>
				</div>
				<div class="col-sm">
					<h4>Contact</h4>
					<ul>
						<li><span>000-000-0000</span></li>
						<li><span>admin@gmail.com</span></li>
					</ul>
				</div>
            </div>
		</div>
    </div>
</div>
</body>
</html>