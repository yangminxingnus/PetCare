<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
echo "This is admin page";
get($conn);
?>

</body>
</html>