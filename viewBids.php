<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
	$result=pg_query($conn, "SELECT * FROM bid");
	while($row=pg_fetch_assoc($result)){
		echo "<ul><form name='diplay' action='viewBids.php' method='POST'>
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

	}
	if(isset($_POST['delete'])){
		$result=pg_query($conn, "DELETE FROM bid WHERE bid='$row[bid]' AND aid='$row[aid]' AND pid='$row[pid]'");
	}

?>

  

