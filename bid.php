<?php
	date_default_timezone_set('Asia/Singapore');
	require_once("dbh.inc.php");
    require_once("text.inc.php");

	include 'header.php';
?>

<?php 
echo "
    <div>
    <form class='form-signin' action='".search($conn)." ".bid($conn)."'  method='POST'>
        <h2 class='form-signin-heading'>Key in details to find your pet carer</h2>
        <input type='text' name='petType'class='form-control'placeholder='pet type' required ><br>
        <input type='date' name='sTime' class='form-control'placeholder='start time' required ><br>
        <input type='date' name='eTime' class='form-control' placeholder='end time' required ><br>
        <button class='btn btn-warning btn-block' type='submit' name='searchASubmit'>Search</button>
    </form>
    </div>

            <div>
                  <form class='form-signin' method='POST'>
                  <input type='text' name='aId'class='form-control'placeholder='availiability id' required ><br>
                   <input type='text' name='bidPoints'class='form-control'placeholder='your points' required ><br>
                   <input type='text' name='petId'class='form-control'placeholder='your pet Id' required ><br>
                   <button class='btn btn-warning btn-block' type='submit' name='bidSubmit'>Bid</button>
                  </form>

            </div>"; 


?>
</body>
</html> 