<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
	require_once("text.inc.php");
	session_start();
  include 'header.php';
?>
<html>
<body background="dogwquote.jpg">
</body>
</html>
<?php
echo"
<div>
      <form class='form-signin' action='".sign_up($conn)."' method='POST'>
        <h2 class='form-signin-heading'>Don't have an account? Sign up now!</h2>
        <input type='text' name='uid' class='form-control' placeholder='Username' required autofocus>
        <input type='password' name='pwd' class='form-control' placeholder='Password' required>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='signupSubmit'>SIGN UP</button>
      </form>

</div>"; 

?>

</body>
</html>