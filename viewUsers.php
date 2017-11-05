<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
	$result=pg_query($conn, "SELECT * FROM users");
	while($row=pg_fetch_assoc($result)){
		echo "<ul><form name='diplay' action='viewUsers.php' method='POST'>
		<li>User ID: $row[uid]</li>
		<li>User Password: $row[password]</li>
		<li>User Bidding points</li>
		<li><input type='text' name='user_pts_updated' value='$row[points]'/></li>
		</form>
		</ul>";
		echo "<div class='panel panel-body'>
		<button class='btn btn-warning btn-block' type='submit' name='update_user'>update</button>
		<button class='btn btn-warning btn-block' type='submit' name='delete_user'>delete</button>
		</div>";
	}
	if(isset($_POST['update_user'])){
		$result=
			pg_query($conn, "UPDATE users SET points='$_POST[user_pts_updated]' WHERE uid='$row[uid]'");
		if (!$result){ echo "Update failed!!";}
        else{echo "Update successful!";}
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

  

