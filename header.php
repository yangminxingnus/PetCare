<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
	require_once("text.inc.php");
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>PetCare</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
	<nav>
		<ul>
			<li><a href="index.php">HOME</a></li>
			<?php
			if($_SESSION['uid'] == 'admin'){?>
				<li><a href="viewPets.php">PETS</a></li>
				<li><a href="viewUsers.php">USERS</a></li>
				<li><a href="viewAvai.php">AVAILABILITIES</a></li>
				<li><a href="viewBids.php">BIDS</a></li>
			<?php
				echo "<form action='".logout()."' method='POST'>
				<button type='submit' name='logoutSubmit' class='btn btn-warning btn-xs'>LOG OUT</button>
			</form>"; 
			}?>

			<?php
			if(isset($_SESSION['uid']) && $_SESSION['uid'] != 'admin'){?>
			<li><a href="profile.php">PROFILE</a></li>
			<li><a href="putAvail.php">BE CARER</a></li>
			<li><a href="bid.php">FIND CARER</a></li>
			<?php
				echo "<form action='".logout()."' method='POST'>
				<button type='submit' name='logoutSubmit' class='btn btn-warning btn-xs'>LOG OUT</button>
			</form>";
			} ?>
			
			<?php
			if(!isset($_SESSION['uid'])){
				echo "<form action='".getLogin($conn)."' method='POST'>
				<input type='text' name='uid' placeholder=' Username' required autofocus>
				<input type='password' name='pwd' placeholder=' Password'required>
				<button type='submit' name='loginSubmit' class='btn btn-warning btn-xs'>LOG IN</button>
			</form>";
			?>
				<li><a href="signup.php">SIGN UP</a></li>
			<?php
			}
			?>

			
		</ul>
	</nav>
</header>