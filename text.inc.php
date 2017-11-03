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

//search
function search($conn){
    if (isset($_POST['searchASubmit'])){
		$pType = $_POST['petType'];
		$sTime = $_POST['sTime'];
		$eTime = $_POST['eTime'];
		$sql = "SELECT * FROM availability a WHERE a.ptype = '$pType' AND ((a.afrom <= '$sTime' AND a.ato >= '$eTime'))";
		
		$result = pg_query($conn, $sql);   
		while ($row = pg_fetch_assoc($result)) {
           
			echo "<div class='panel panel-warning'>

			<div class='panel panel-heading'><h3>";
			echo $row['aid']."</h3>";
			echo "</div>

			<div class='panel panel-body' method='POST'>";
  		    echo $row['cid']."</h3>". "        " .$row['uid']."</h3>". "        " .$row['ptype']."</h3>". "        " .$row['afrom']."</h3>". "        " .$row['ato']."</h3>";
		    
		    echo "
           <div>
                  <form class='form-signin' action='".bid($conn)."' method='POST'>
                  <input type='text' name='aId'class='form-control'placeholder='availability' required ><br>
                   <input type='text' name='bidPoints'class='form-control'placeholder='your points' required ><br>
                   <input type='text' name='petId'class='form-control'placeholder='your pet Id' required ><br>
                   <button class='btn btn-warning btn-block btn-xs' type='submit' name='bidSubmit'>Bid</button>
                  </form>

            </div>"; 

			echo "</div></div>";
	    }
	}
}

//search
function bid($conn){
    if (isset($_POST['bidSubmit'])){	
    	$points = $_POST['bidPoints'];
        $petId = $_POST['petId'];
        $uid = $_SESSION['uid'];

	    // $result2 = pg_query($conn, "SELECT p.pid FROM pets p, users u WHERE u.uid = p.oid AND p.pid = '$petId'");
	    // $row = pg_fetch_assoc($result2);
	    // $pid = $row[pid];
		$sql = "INSERT INTO bid VALUES ('$uid', '$aid', '$petId', 'pending', $points)";
		$result = pg_query($conn, $sql);  
		if (!$result) {
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
			  Bid failed. $sql
			</div>";
		} else {
			//header("Location: index.php");
			echo "<div class='alert alert-success alert-dismissible' role='alert'>
			  Bid successfully!
			</div>";
		}
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


//get the infomation of the blogs
function get($conn){
	$sql = "SELECT * FROM texts";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<div class='panel'><div class='panel panel-heading'><h3>";
		echo $row['uid']."</h3>"."   ".$row['date'];
		echo "</div><div class='panel panel-body'>";
		echo $row['message'];
		if(isset($_SESSION['uid'])){
			if($_SESSION['uid']==$row['uid']){
				echo "<form class='delete-form' method='POST' action='".delete($conn)."'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<button type=submit name = 'TextDelete' class='btn btn-warning btn-xs'>DELETE</button>
			</form>
			<form class='edit-form' method='POST' action='editText.php'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<input type='hidden' name='uid' value='".$row['uid']."'>
				<input type='hidden' name='date' value='".$row['date']."'>
				<input type='hidden' name='message' value='".$row['message']."'>
				<button class='btn btn-warning btn-xs'>EDIT</button>
			</form>";
			} 
		}
		echo "</div></div>";
	}
	
}


?>