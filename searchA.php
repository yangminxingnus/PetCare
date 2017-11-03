<html>
<body>

<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
	include 'header.php';
?>

<div>
Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>
</div>

</body>
</html> 