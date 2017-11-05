<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
	$result=pg_query($conn, "SELECT * FROM availability");
	while($row=pg_fetch_assoc($result)){
		echo "<ul><form name='diplay' action='viewAvai.php' method='POST'>
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
		<button class='btn btn-warning btn-block' type='submit' name='update_avai'>update</button>
		<button class='btn btn-warning btn-block' type='submit' name='delete_avai'>delete</button>
		</div>";
		
	}
	if(isset($_POST['update_avai'])){
		$result=pg_query($conn, "UPDATE availability SET cid='$_POST[carer_id_updated]', ptype='$_POST[pet_type_updated]',afrom='$_POST[from_updated]', ato='$_POST[to_updated]' WHERE aid='$row[aid]'");
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

  

