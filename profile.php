<!DOCTYPE html>

<body>
	<h2>Add a new pet to database</h2>
	<ul>
		<form name = "display" action="profile.php" method="POST" >
			<li>Pet information:</li>
			<li><input type="text" name="Pet ID"></li>
			<li><input type="text" name="Pet name"></li>
			<li><input type="text" name="Pet type"></li>
			<li><input type="submit" name="submit"></li>
		</form>
	</ul>

<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';

    $db = pg_connect("host=localhost port=5432 dbname=Project1 user=postgres password=")
    $result = pg_query($db, "SELECT * FROM pets WHERE oid = uid")
    while ($row = pg_fetch_row($result)) {
    	echo "<ul><form name='update' action = 'profile.php' method = 'POST'
    	<li>Pet ID:</li>
    	<li><input type = 'text' name = 'petid_updated' value = '$row[pid]' /></li>
    	<li>Pet Name:</li>
    	<li><input type = 'text' name = 'pet_name_updated' value = '$row[pname]' /></li>
    	<li>Pet type:</li>
    	<li><input type = 'text' name = 'pet_type_updated' value = '$row[ptype]' /></li>
    	</form>
    	</ul>";
    }
    echo "<li><input type = 'submit' name = 'new' /></li>";
    if (isset($_POST['new'])) {
    	$result = pg_query($db, "UPDATE pet SET book_id)
    }
?>

<?php
echo "This is the profile page!";
get($conn);
?>

</body>
</html>