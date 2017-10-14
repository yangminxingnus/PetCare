<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
	require_once("text.inc.php");
	session_start();
    include 'header.php';
?>

<?php
if (isset($_SESSION['id'])) {
	echo "<div><br><h2>"."Hello ";
	echo $_SESSION['uid'];
	echo "!</h2><br></div>";
} else {
	echo "<div class='alert alert-warning alert-dismissible' role='alert'>
			<strong>You are not logged in.</strong>
			</div>";
}
echo "<br><br>";
get($conn);
?>

</body>
</html>