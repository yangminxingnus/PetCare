<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
	$result=pg_query($conn, "SELECT * FROM users");
	while($row=pg_fetch_assoc($result)){
		echo "
		<div>
		<form class='form-signin' action='viewUsers.php' method='POST'>
		<label>User ID: $row[uid]</label><br>
		<input type='hidden' name='uid' class='form-control' placeholder='availability' value='$row[uid]' required >
		<label>User Password: $row[password]</label><br>
		<label>User Bidding points:</label><input type='text' name='user_pts_updated' class='form-control' value='$row[points]'/><br>
		<button class='btn btn-lg btn-warning btn-block' type='submit' name='update_user'>update</button>
		<button class='btn btn-lg btn-warning btn-block' type='submit' name='delete_user'>delete</button>
		</form>
		</div>";
	}

	if(isset($_POST['update_user'])){
		$sql = "UPDATE users SET points='$_POST[user_pts_updated]' WHERE uid='$_POST[uid]'";
		$result = pg_query($conn, $sql);
		if (!$result){ echo "Update failed!!";}
        else{echo "Update successful! $sql" ;}	
	}

	if(isset($_POST['delete_user'])){
		$result1=pg_query($conn, "DELETE FROM bid WHERE bid='$row[uid]'");
		$result2=pg_query($conn, "DELETE FROM availability WHERE cid='$row[uid]'");
		$result3=pg_query($conn, "DELETE FROM pets WHERE oid=$row[uid]");
		$result4=pg_query($conn, "DELETE FROM users WHERE uid=$row[uid]");
		if($result1&&$result2&&$result3&&$result){
			echo "Delete successful!";
		}
		else{
			echo "Delete failed!";
		}
	}

?>

<html>
<body background="images/pet.jpg"
</body>
</html> 

  

