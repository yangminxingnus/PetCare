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
        }
  }

  echo"
  <div>
      <form class='form-signin' action='profile.php' method='POST'>
        <h2 class='form-signin-heading'>Add a new pet</h2>
        <input type='text' name='pid' class='form-control' placeholder='Pet ID' required autofocus>
        <input type='text' name='pname' class='form-control' placeholder='Pet Name' required>
        <input type='text' name='ptype' class='form-control' placeholder='Pet Type' required>
        <button class='btn btn-lg btn-warning btn-block' type='submit' name='addPetSubmit'>Add a Pet</button>
      </form>

  </div>";


  if (isset($_POST['addPetSubmit'])) {
  $result2 = pg_query($conn, "INSERT INTO pets VALUES ('$_POST[pid]', 
    '$_POST[pname]', '$_POST[ptype]', '$uid')");
  if (!$result2) {
    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
        Add failed, the pet ID has already existed!!
      </div>";
         
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Add pet successfully!
      </div>";
    }
  }
  $result3 = pg_query($conn, "SELECT * 
  FROM availability a, bid b
  WHERE a.aid = b.aid
  AND b.bid = '$uid'");
  echo "<div>
  <form class='form-signin' action='profile.php' method='POST'>
  <h2 class='form-signin-heading'>All slots I bid</h2>
  </form>
  </div>";
  while ($row = pg_fetch_assoc($result3)) {
    echo "<div class='panel panel-warning'><div class='panel panel-heading'><h3>";
        echo "Pet ID: ".$row['pid'];
        echo "</div><div class='panel panel-body'>";
        echo "From    ".$row['afrom']."</h3>"."  to  ".$row['ato'];
        echo "<br>Points: ".$row['points']." ";
        echo "<br>Status: ".$row['status']." ";
        echo "</div></div>";
  }


?>

<html>
<body background="images/dogs.jpg">
</body>
</html>