<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
	require_once("text.inc.php");
	include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>Title of the document</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
$id = $_POST['id'];
$uid = $_POST['uid'];
$date = $_POST['date'];
$message = $_POST['message'];

echo "<br><form  method='POST' action='".edit($conn)."'>
	<input type='hidden' name='id' value='".$_POST['id']."'>
	<input type='hidden' name='uid' value='".$_POST['uid']."'>
	<input type='hidden' name='date' value='".$_POST['date']."'>
	<textarea name='message'>".$message."</textarea>
	<button type='submit' name='TextSubmit' class='btn btn-warning btn-lg'>Edit</button>
</form>";

?>
</body>
</html>