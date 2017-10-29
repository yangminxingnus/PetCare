<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
	require_once("putAvail.php");
    include 'header.php';
    session_start();
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
$aid = $_POST['aid'];
$ptype = $_POST['ptype'];
$afrom = $_POST['afrom'];
$ato = $_POST['ato'];

echo "<br><form  method='POST' action='".update($conn)."'>
	<input type='hidden' name='ptype' value='".$_POST['ptype']."'>
	<input type='hidden' name='afrom' value='".$_POST['afrom']."'>
	<input type='hidden' name='ato' value='".$_POST['ato']."'>
	<button type='submit' name='TextSubmit' class='btn btn-warning btn-lg'>Edit</button>
</form>";

?>
</body>
</html>

