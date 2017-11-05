<?php
	  date_default_timezone_set('Asia/Singapore');
	  require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
	$result=pg_query($conn, "SELECT * FROM pets");
	while($row=pg_fetch_assoc($result)){
		echo "<div>
      <form class='form-signin' action='viewPets.php' method='POST'>
        <label>Pet ID:</label><input type='text' name='pet_id_updated' class='form-control' 
        value = '$row[pid]' required autofocus>
        <label>Pet Name:</label><input type='text' name='pet_name_updated' class='form-control' 
        value = '$row[pname]' required>
        <label>Pet Type:</label><input type='text' name='pet_type_updated' class='form-control' 
        value = '$row[ptype]' required>
        <label>Owner ID:</label><input type='text' name='owner_id_updated' class='form-control' 
        value = '$row[oid]' required><br>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='update_pet'>update
        </button>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='delete_pet'>delete
        </button>
      </form>

      </div>";
	}
	if(isset($_POST['update_pet'])){
		$result=pg_query($conn, "UPDATE pets SET oid='$_POST[owner_id_updated]',pname='$_POST[pet_name_updated]',ptype='$_POST[pet_type_updated]' WHERE pid='$_POST[pet_id_updated]'");
    	    if (!$result){ echo "Update failed!!";}
        	else {echo "Update successful!";}
    }
	if(isset($_POST['delete_pet'])){
		$result1=pg_query($conn, "DELETE FROM pets WHERE pid='$_POST[pet_id_updated]'");
		$result=pg_query($conn, "DELETE FROM pets WHERE oid='$_POST[owner_id_updated]'");
		if (!$result1){ echo "Delete failed!!";}
   		else{
       		if(!$result){ echo "Delete failed!";}
   			else {echo "Delete successful!";}
		}
	}

?>

<html>
<body background="images/dogcat.jpg"
</body>
</html> 

