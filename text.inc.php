<?php

//get a user log in
function getLogin($conn){
	if (isset($_POST['loginSubmit'])) {
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		$sql = "SELECT * FROM users WHERE uid='$uid' AND password='$pwd'";
		$result = pg_query($conn, $sql);
		if (pg_num_rows($result)>0) {
			if ($row = pg_fetch_assoc($result)) {
				echo "<br><h2>"."     Hello ";
				$_SESSION['id'] = $row['uid'];
				$_SESSION['uid'] = $_POST['uid'];

				if ($_SESSION['id'] == "admin") {
					header("Location: admin.php?loginsuccess");
				} else {
					header("Location: index.php?loginsuccess");
				}
				
				exit();
			}
		} else {	
			header("Location: index.php");
		}
	}
	
	
	
}

//Log out the user
function logout(){
	if (isset($_POST['logoutSubmit'])) {
		session_start();
		session_destroy();
		header("Location: index.php");
		exit();
	}
}

//submit the sign up information
function sign_up($conn){
	if (isset($_POST['signupSubmit'])){
		$uid = $_POST['uid'];
		$pwd = $_POST['pwd'];
		$sql1 = "SELECT * FROM users WHERE uid='$uid'";
		$result1 = pg_query($conn, $sql1);
		if (pg_num_rows($result1)>0) {
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
			  This username has been used. Please try again.
			</div>";
		} else {
			$sql = "INSERT INTO users VALUES ('$uid', '$pwd', 500)";
			$result = pg_query($conn, $sql);
			//header("Location: index.php");
			echo "<div class='alert alert-success alert-dismissible' role='alert'>
			  You have signed up successfully!
			</div>";
		}
		
	}
}

?>