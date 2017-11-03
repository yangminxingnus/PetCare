<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
echo "This is admin page";
echo "<div>
		<form class='panel panel-body' action='admin.php' method='POST'>
		<button class='btn btn-warning btn-block' type='submit' name='pets'>View Pets</button>
		<button class='btn btn-warning btn-block' type='submit' name='users'>View Users</button>
		<button class='btn btn-warning btn-block' type='submit' name='availabilities'>View Availabilities
		</button>
		<button class='btn btn-warning btn-block' type='submit' name='bids'>View Bids</button>
		</form>
	</div>";
$pets=$_POST['pets'];
$users=$_POST['users'];
$avai=$_POST['availabilities'];
$bids=$_POST['bids'];
if (isset($pets)) {
	$result=pg_query($conn, "SELECT * FROM pets");
	while($row=pg_fetch_assoc($result)){
		echo "<ul><form name='diplay' action='admin.php' method='POST'>
		<li>Pet ID: $row[pid]</li>
		<li>Pet Name:</li>
		<li><input type='text' name='pet_name_updated' value='$row[pname]'/></li>
		<li>Pet Type</li>
		<li><input type='text' name='pet_type_updated' value='$row[ptype]'/></li>
		<li>Owner ID</li>
		<li><input type='text' name='owner_id_updated' value='$row[oid]'/></li>
		</form>
		</ul>";
		echo "<div class='panel panel-body'>
		<button class='btn btn-warning btn-block' type='submit' name='update'>update</button>
		<button class='btn btn-warning btn-block' type='submit' name='delete'>delete</button>
		</div>";
		if(isset($_POST['update'])){
			$result=pg_query($conn, "UPDATE pets SET oid='$_POST[owner_id_updated]'pname='$_POST[pet_name_updated]',ptype='$_POST[pet_type_updated]'WHERE pid='$row[pid]'");
        	if (!$result){ echo "Update failed!!";}
        	else{echo "Update successful!";}
    	}
		elseif(isset($_POST['delete'])){
			$result1=pg_query($conn, "DELETE FROM pets WHERE pid='$row[pid]'");
			$result=pg_query($conn, "DELETE FROM pets WHERE oid='$_POST[owner_id_updated]'");
		if (!$result1){ echo "Delete failed!!";}
       	else{
       		if(!$result){ echo "Delete failed!";}
       		else {echo "Delete successful!";}
		}
	}
}
}
elseif(isset($users)){
	$result=pg_query($conn, "SELECT * FROM users");
	while($row=pg_fetch_assoc($result)){
		echo "<ul><form name='diplay' action='admin.php' method='POST'>
		<li>User ID: $row[uid]</li>
		<li>User Password: $row[password]</li>
		<li>User Bidding points</li>
		<li><input type='text' name='user_pts_updated' value='$row[points]'/></li>
		</form>
		</ul>";
		echo "<div class='panel panel-body'>
		<button class='btn btn-warning btn-block' type='submit' name='update'>update</button>
		<button class='btn btn-warning btn-block' type='submit' name='delete'>delete</button>
		</div>";
		if(isset($_POST['update'])){
			$result=pg_query($conn, "UPDATE users SET points='$_POST[user_pts_updated]' WHERE uid='$row[uid]'");
			if (!$result){ echo "Update failed!!";}
        	else{echo "Update successful!";}
		}
		elseif(isset($_POST['delete'])){
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
	}
}
elseif(isset($avai)){
	$result=pg_query($conn, "SELECT * FROM availability");
	while($row=pg_fetch_assoc($result)){
		echo "<ul><form name='diplay' action='admin.php' method='POST'>
		<li>Availability ID: $row[aid]</li>
		<li>Carer ID</li>
		<li><input type='text' name='carer_id_updated' value='$row[cid]'/></li>
		<li>Prefered Pet Type</li>
		<li><input type='text' name='pet_type_updated' value='$row[ptype]'/></li>
		<li>From</li>
		<li><input type='text' name='from_updated' value='$row[afrom]'/></li>
		<li>To</li>
		<li><input type='text' name='to_updated' value='$row[ato]'/></li>
		</form>
		</ul>";
		echo "<div class='panel panel-body'>
		<button class='btn btn-warning btn-block' type='submit' name='update'>update</button>
		<button class='btn btn-warning btn-block' type='submit' name='delete'>delete</button>
		</div>";
		if(isset($_POST['update'])){
			$result=pg_query($conn, "UPDATE availability SET cid='$_POST[carer_id_updated]', ptype='$_POST[pet_type_updated]',afrom='$_POST[from_updated]', ato='$_POST[to_updated]' WHERE aid='$row[aid]'");
			if(!$result) {echo "Update failed!";}
			else {echo "Update successful!";}
		}
		elseif(isset($_POST['delete'])){
			$result1=pg_query($conn, "DELETE FROM bid WHERE aid='$row[aid]'");
			$result2=pg_query($conn, "DELETE FROM availability WHERE aid='$row[aid]'");
			if($result1&&$result2){echo "Delete successful!";}
			else{echo "Delete failed!";}
		}
	}
}
elseif (isset($bids)) {
	$result=pg_query($conn, "SELECT * FROM bid");
	while($row=pg_fetch_assoc($result)){
		echo "<ul><form name='diplay' action='admin.php' method='POST'>
		<li>Bidder ID</li>
		<li><input type='text' name='bidder_id_updated' value='$row[bid]'/></li>
		<li>Availability ID</li>
		<li><input type='text' name='avai_id_updated' value='$row[aid]'/></li>
		<li>Pet ID</li>
		<li><input type='text' name='pet_id_updated' value='$row[pid]'/></li>
		<li>Status: $row[status]</li>
		<li>Bidding Points</li>
		<li><input type='text' name='bid_pts_updated' value='$row[points]'/></li>
		<li><input type='submit' name='delete' value='delete'/></li>
		</form>
		</ul>";
		if(isset($_POST['delete'])){
			$result=pg_query($conn, "DELETE FROM bid WHERE bid='$row[bid]' AND aid='$row[aid]' AND pid='$row[pid]'");
		}
	}
}
?>

  

