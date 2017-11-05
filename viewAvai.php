<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
	$result=pg_query($conn, "SELECT * FROM availability");
	while($row=pg_fetch_assoc($result)){
        echo "
		<div>
		<form class='form-signin' action='viewAvai.php' method='POST'>
		<label>Availability ID: $row[aid]</label>
		<label>Carer ID: </label><input type='text' name='carer_id_updated' class='form-control' value='$row[cid]'/>
		<label>Prefered Pet Type:</label><input type='text' name='pet_type_updated' class='form-control' value='$row[ptype]'/>
		<label>From: </label><input type='text' name='from_updated' class='form-control' value='$row[afrom]'/>
		<label>To:</label><input type='text' name='to_updated' class='form-control' value='$row[ato]'/><br>
		<input type='hidden' name='aid'placeholder='availability' class='form-control' value='$row[aid]' required >
		<button class='btn btn-lg btn-warning btn-block' type='submit' name='update_avai'>update</button>
		<button class='btn btn-lg btn-warning btn-block' type='submit' name='delete_avai'>delete</button>
		</form>
		</div>";
		
	}
	if(isset($_POST['update_avai'])){
		$result=pg_query($conn, "UPDATE availability SET cid='$_POST[carer_id_updated]', ptype='$_POST[pet_type_updated]',afrom='$_POST[from_updated]', ato='$_POST[to_updated]' WHERE aid='$_POST[aid]'");
		if(!$result) {echo "Update failed!";}
		else {echo "Update successful!";}
	}
	if(isset($_POST['delete_avai'])){
		$result1=pg_query($conn, "DELETE FROM bid WHERE aid='$row[aid]'");
		$result2=pg_query($conn, "DELETE FROM availability WHERE aid='$row[aid]'");
		if($result1&&$result2){echo "Delete successful!";}
		else{echo "Delete failed!";}
	}
?>

<html>
<body background="images/doginbag.jpg"
</body>
</html> 
