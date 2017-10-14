<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    include 'header.php';
?>

<?php
echo "This is the page for putting availability!";
get($conn);
?>

</body>
</html>