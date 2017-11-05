<?php
date_default_timezone_set('Asia/Singapore');
require_once("dbh.inc.php");
require_once("text.inc.php");
include 'header.php';
?>

<?php 
echo "
<div Id = head>
<form class='form-signin' action='".search($conn)." ".bid($conn)."'  method='POST'>
<h2 class='form-signin-heading'>Key in details to find your pet carer</h2>
<input type='text' name='petType'class='form-control'placeholder='pet type' required ><br>
<h4 class='form-signin-heading'>From</h4>
<input type='date' name='sTime' class='form-control'placeholder='start time' required ><br>
<h4 class='form-signin-heading'>To</h4>
<input type='date' name='eTime' class='form-control' placeholder='end time' required ><br>
<button class='btn btn-warning btn-block' type='submit' name='searchASubmit'>Search</button>
</form>
</div>";
getAvail($conn);
?>

<?php
//search
function search($conn){


  if (isset($_POST['searchASubmit'])){
    ?>
    <style type="text/css">
    #head{
     display:none;
   }</style>
   <?php

   $pType = $_POST['petType'];
   $sTime = $_POST['sTime'];
   $eTime = $_POST['eTime'];
   $sql = "SELECT * FROM availability a WHERE a.ptype = '$pType' AND ((a.afrom <= '$sTime' AND a.ato >= '$eTime'))";

   $result = pg_query($conn, $sql);   
   while ($row = pg_fetch_assoc($result)) {

    echo "<div class='panel panel-warning'><div class='panel panel-heading'><h3>";
    echo $row['aid']."</h3>";
    echo "</div><div class='panel panel-body' method='POST'>";
    echo "Poster: ".$row['cid']."</h3>". " |    Pet Type: " .$row['ptype']."</h3>". " |    From: " .$row['afrom']."</h3>". "  |    To:  " .$row['ato']."</h3>";

    echo "<form class='delete-form' action='".bid($conn)."' method='POST'>
    <input type='hidden' name='aId' placeholder='availability' value='".$row['aid']."' required >
    <input type='number' min='0' name='bidPoints' placeholder='your points' required >
    <input type='text' name='petId'placeholder='your pet Id' required >
    <button class='btn btn-warning btn-xs' type='submit' name='bidSubmit'>Bid</button>
    </form>"; 

    echo "</div></div>";
  }
}
}

function bid($conn){
  if (isset($_POST['bidSubmit'])){  
    $points = $_POST['bidPoints'];
    $petId = $_POST['petId'];
    $uid = $_SESSION['uid'];
    $aid = $_POST["aId"];

    // Check whether user have enough points
    $sql1 = "SELECT * FROM users WHERE uid = '$uid'";
    $result1 = pg_query($conn, $sql1); 
    $userRow = pg_fetch_assoc($result1);
    $totalPoints = $userRow[points];
    $pointsLeft = $totalPoints - $points;

    if ($pointsLeft > 0) {
      // User has enough points
      $sql = "INSERT INTO bid VALUES ('$uid', '$aid', '$petId', 'pending', $points)";
      if (pg_query($conn, $sql)) {
        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        Bid failed. $sql
        </div>";
      } else {
        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Bid successfully! $sql
        </div>";
      }
    } else {
      // User doesn't have enough points

      echo "<div><div class='alert alert-danger alert-dismissible' role='alert'>
      Points you have: $totalPoints. Points you bid: $points. You don't have enough points. Bid failed.
      </div></div>";
    }
  }
}

function getAvail($conn){
  $sql = "SELECT * FROM availability";
  $result = pg_query($conn, $sql);
  while ($row = pg_fetch_assoc($result)) {

    echo "<div class='panel panel-warning'><div class='panel panel-heading'><h3>";
    echo $row['aid']."</h3>";
    echo "</div><div class='panel panel-body' method='POST'>";
    echo "Poster: ".$row['cid']."</h3>". " |    Pet Type: " .$row['ptype']."</h3>". " |    From: " .$row['afrom']."</h3>". "  |    To:  " .$row['ato']."</h3>";

    echo "<form class='delete-form' action='".bid($conn)."' method='POST'>
    <input type='hidden' name='aId'placeholder='availability' value='".$row['aid']."' required >
    <input type='text' name='bidPoints'placeholder='your points' required >
    <input type='text' name='petId'placeholder='your pet Id' required >
    <button class='btn btn-warning btn-xs' type='submit' name='bidSubmit'>Bid</button>
    </form><br>"; 
    echo "</div></div>";
  }
  
}

?>

<html>
<body background="images/pet.jpg"
</body>
</html> 

