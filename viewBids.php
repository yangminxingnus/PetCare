<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
	$result=pg_query($conn, "SELECT * FROM bid");
	while($row=pg_fetch_assoc($result)){
		echo "<div>
        <form class='form-signin' action='viewBids.php' method='POST'>
			<label>Bidder ID: $row[bid]</label><br>
			<label>Availability ID: $row[aid]</label><br>
			<label>Pet ID: $row[pid]</label></br>
			<label>Status: $row[status]</label></br>
			<label>Bidding Points: $row[points]</label></br>
			<input type='hidden' name='aid' class='form-control' value='$row[aid]' required >
			<input type='hidden' name='bid' class='form-control' value='$row[bid]' required >
			<input type='hidden' name='pid' class='form-control' value='$row[pid]' required >
		<button class='btn btn-lg btn-warning btn-block' type='submit' name='delete'>delete</button>
		</form>
		</div>";

	}
	if(isset($_POST['delete'])){
		$result=pg_query($conn, "DELETE FROM bid WHERE bid = '$_POST[bid]' AND aid = '$_POST[aid]' AND pid = '$_POST[pid]'");
        if ($result) {
            echo"deleted!";
        } else {
            echo"error DELETE FROM bid WHERE bid='$_POST[bid]' AND aid = '$_POST[aid]' AND pid='$_POST[pid]'";
        }
		
	}

?>

<html>
<body background="images/dogcat.jpg"
</body>
</html> 

 
