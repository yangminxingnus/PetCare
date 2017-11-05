  <?php
    date_default_timezone_set('Asia/Singapore');
    require_once("dbh.inc.php");
    include 'header.php';
  ?>

  <?php
  $uid = $_SESSION['uid'];
  echo "<div>
  <h2 class='form-signin-heading'>This is the profile page for $uid!</h2>
  </div>";


  $result = pg_query($conn, "SELECT * FROM users WHERE uid = '$uid'");
  $row = pg_fetch_assoc($result);

  echo "<div>
  <h2 class='form-signin-heading'>My bidding points:  $row[points] </h2>
  </div>";

  echo"
  <div>
      <form class='form-signin' action='profile.php' method='POST'>
        <h2 class='form-signin-heading'>Change my password</h2>
        <input type='text' name='new_password' class='form-control' placeholder='New Password' required autofocus>
        <input type='text' name='re_enter_password' class='form-control' placeholder='Enter the new password again' required>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='changePasswordSubmit'>Change Password</button>
      </form>

  </div>";



    if (isset($_POST['changePasswordSubmit'])) {
      if ($_POST[new_password] <> $_POST[re_enter_password]) {
        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        Two passwords are different!!
        </div>";

      } else {
        pg_query($conn, "UPDATE users SET password = '$_POST[new_password]' WHERE uid = '$uid'");
      
        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Update password successfully!
      </div>";
      }
    }


  echo "<div>
  <form class='form-signin' action='profile.php' method='POST'>
    <h2 class='form-signin-heading'>My pets</h2>
  </form>
  </div>";  
  $result = pg_query($conn, "SELECT * FROM pets WHERE oid = '$uid'" );
  while ($row = pg_fetch_assoc($result)) {

    echo"
      <div>
      <form class='form-signin' action='profile.php' method='POST'>

        <label>Pet ID:</label><input type='text' name='pet_id_updated' class='form-control' 
        value = '$row[pid]' required autofocus>
        <label>Pet Name:</label><input type='text' name='pet_name_updated' class='form-control' 
        value = '$row[pname]' required>
        <label>Pet Type:</label><input type='text' name='pet_type_updated' class='form-control' 
        value = '$row[ptype]' required>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='update_pet'>Update this pet
        </button>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='delete_pet'>Delete this pet
        </button>
      </form>

      </div>";
    
    }

  if (isset($_POST['update_pet'])) {
  $result1 = pg_query($conn, "UPDATE pets SET
   pname = '$_POST[pet_name_updated]', ptype = '$_POST[pet_type_updated]' 
   WHERE pid = '$_POST[pet_id_updated]' ");
  if (!$result1) {
            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        update pet information failed!
      </div>";
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Update pet information successfully!
      </div>";

      echo "<meta http-equiv='refresh' content = '3'>";
      
        }
      
    }
  if (isset($_POST['delete_pet'])) {
    $result1 = pg_query($conn, "DELETE FROM pets WHERE pid = '$_POST[pet_id_updated]'");
    if (!$result1) {
      echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        Delete failed, this pet is in the bidding list!!
       </div>";
           
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Delete pet successfully!
      </div>";
     
      echo "<meta http-equiv='refresh' content = '3'>";
        }
  }

  echo"
  <div>
      <form class='form-signin' action='profile.php' method='POST'>
        <h2 class='form-signin-heading'>Add a new pet</h2>
        <input type='text' name='pid' class='form-control' placeholder='Pet ID' required autofocus>
        <input type='text' name='pname' class='form-control' placeholder='Pet Name' required>
        <input type='text' name='ptype' class='form-control' placeholder='Pet Type' required>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='addPetSubmit'>Add a Pet
        </button>
      </form>

  </div>";


  if (isset($_POST['addPetSubmit'])) {
  $result1 = pg_query($conn, "INSERT INTO pets VALUES ('$_POST[pid]', 
    '$_POST[pname]', '$_POST[ptype]', '$uid')");
  if (!$result1) {
    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        Add failed, the pet ID has already existed!!
      </div>";
         
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Add pet successfully!
      </div>";
      
      echo "<meta http-equiv='refresh' content = '3'>";
    }
  }

  $result3 = pg_query($conn, "SELECT * 
  FROM availability a, bid b
  WHERE a.aid = b.aid
  AND b.bid = '$uid'
  AND b.status = 'pending'");

  echo "<div>
  <form class='form-signin' action='profile.php' method='POST'>
  <h2 class='form-signin-heading'>All slots I am bidding now</h2>
  </form>
  </div>";

  while ($row = pg_fetch_assoc($result3)) {
    echo "<div class='panel panel-warning'><div class='panel panel-heading'><h3>";
        echo "Pet ID: ".$row['pid'];
        echo "<form class='delete-form' action='profile.php' method='POST'>
         <input type='hidden' name='pId' placeholder='availability' value='".$row['pid']."' required >
         <input type='hidden' name='aId' placeholder='availability' value='".$row['aid']."' required >
         <input type='number' min='0' name='newPoints' placeholder='update points' value = ".$row['points']." required >
         <button class='btn btn-warning btn-xs' type='submit' name='bidUpdate'>Update bid</button>
         <button class='btn btn-warning btn-xs' type='submit' name='bidDelete'>Quit this bid</button>
         </form>";
        echo "</div><div class='panel panel-body'>";
        echo "Carer:  ".$row['cid']." ";
        echo "<br>From    ".$row['afrom']."</h3>"."  to  ".$row['ato'];
        echo "<br>Points: ".$row['points']." ";
        echo "<br>Status: ".$row['status']." ";
        echo "</div></div>";
        
  }

  if (isset($_POST['bidUpdate'])) {
      $aid = $_POST['aId'];
      $pid = $_POST['pId'];
      $points = $_POST['newPoints'];
      $bid = $_SESSION['uid'];

      //Check enough points
      $result3a = pg_query($conn, "SELECT * FROM users WHERE uid = '$uid'"); 
      $userRow = pg_fetch_assoc($result3a);
      $totalPoints = $userRow[points];
      $pointsLeft = $totalPoints - $points;

      if ($pointsLeft >= 0) {
        $result3b = pg_query($conn, "UPDATE bid SET points = '$points' 
          WHERE aid = '$aid' AND pid = '$pid' AND bid = '$bid'");
        if (!$result3b) {
          echo "<div class='alert alert-danger alert-dismissible' role='alert'>
             Change bidding points failed.
             </div>";
         
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
              Change bidding points successfully!
              </div>";
            echo "<meta http-equiv='refresh' content = '3'>";
      
        }
      } else { // User doesn't have enough points
          echo "<div><div class='alert alert-danger alert-dismissible' role='alert'>
            Points you have: $totalPoints. Points you bid: $points. You don't have enough points. Bid failed.
            </div></div>";
    }
  }

  if (isset($_POST['bidDelete'])) {
      $aid = $_POST['aId'];
      $pid = $_POST['pId'];
      $bid = $_SESSION['uid'];
      $result3c = pg_query($conn, "DELETE FROM bid  WHERE aid = '$aid' AND pid = '$pid' AND bid = '$bid'");
      if (!$result3c) {
          echo "<div class='alert alert-danger alert-dismissible' role='alert'>
             Quit failed.
             </div>";
         
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
              Quit successfully!
              </div>";
            echo "<meta http-equiv='refresh' content = '3'>";
        }
  }

  $result4 = pg_query($conn, "SELECT * 
  FROM availability a, bid b
  WHERE a.aid = b.aid
  AND b.bid = '$uid'
  AND b.status = 'successful'");

  echo "<div>
  <form class='form-signin' action='profile.php' method='POST'>
  <h2 class='form-signin-heading'>My bidding history</h2>
  </form>
  </div>";

  while ($row = pg_fetch_assoc($result4)) {
    echo "<div class='panel panel-warning'><div class='panel panel-heading'><h3>";
        echo "Pet ID: ".$row['pid'];
        echo "</div><div class='panel panel-body'>";
        echo "Carer:  ".$row['cid']." ";
        echo "<br>From    ".$row['afrom']."</h3>"."  to  ".$row['ato'];
        echo "<br>Points: ".$row['points']." ";
        echo "<br>Status: ".$row['status']." ";
        echo "</div></div>";
  }

  $result4 = pg_query($conn, "SELECT * 
  FROM availability a, bid b
  WHERE a.aid = b.aid
  AND b.bid = '$uid'
  AND b.status = 'failed'");

  while ($row = pg_fetch_assoc($result4)) {
    echo "<div class='panel panel-warning'><div class='panel panel-heading'><h3>";
        echo "Pet ID: ".$row['pid'];
        echo "</div><div class='panel panel-body'>";
        echo "Carer:  ".$row['cid']." ";
        echo "<br>From    ".$row['afrom']."</h3>"."  to  ".$row['ato'];
        echo "<br>Points: ".$row['points']." ";
        echo "<br>Status: ".$row['status']." ";
        echo "</div></div>";
  }

?>

<html>
<body background="images/dogs.jpg">
</body>
</html>