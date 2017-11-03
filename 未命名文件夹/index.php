<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <style type = "text/css">
  table, th, td {border: 1px solid black};
 </style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Supply Userid</h2>
  <ul>
    <form name="display1" action="index.php" method="POST" >
      <li>User ID:</li>
      <li><input type="text" name="userid" /></li>
      <li><input type="submit" name="submit1" /></li>
    </form>
  </ul>
  <h2>Search Aviliability</h2>
  <ul>
    <form name="display2" action="index.php" method="POST" >
      <li>Pet Type:</li>
      <li><input type="text" name="pettype" /></li>
      <li>Time from:</li>
      <li><input type="text" name="timefrom" value="YYYY-MM-DD"/></li>
      <li>Time to:</li>
      <li><input type="text" name="timeto" value="YYYY-MM-DD"/></li>
      <li><input type="submit" name="submit2" /></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
//    $db     = pg_connect("host=localhost port=5432 dbname=petCare user=postgres password=19980Ymx");	
//    $result1 = pg_query($db, "SELECT * FROM book where book_id = '$_POST[userid]'");		// Query
//	$result2 = pg_query($db, "SELECT * FROM avaliability a where a.uid = '$_POST[userid]'");	//Query
//	$result3 = pg_query($db, "SELECT * FROM pets p where p.ownerid = '$_POST[userid]'");	//Query
//    $row1    = pg_fetch_assoc($result1);		// To store the result row
//	$row2    = pg_fetch_assoc($result2);
//	$row2    = pg_fetch_assoc($result3);
	// To store the result row
    if (isset($_POST['submit1']) || isset($_POST['submit2'])) {
        try {
            $con= new PDO('pgsql:host=localhost;dbname=petCare', "postgres", "19980Ymx");
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
			if(isset($_POST['submit1'])) {
				$query = "SELECT * FROM users u where u.userid = '$_POST[userid]'";
			} else {
				$query = "SELECT * FROM availability a where a.ptype = '$_POST[pettype]' 
			              AND '$_POST[timefrom]' >= a.afrom
					      AND '$_POST[timeto]' <= a.ato";
			}
            //first pass just gets the column names
            print "<table>";
            $result = $con->query($query);
            //return only the first row (we only need field names)
            $row = $result->fetch(PDO::FETCH_ASSOC);
            print " <tr> ";
            foreach ($row as $field => $value){
            print " <th>$field</th> ";
            } // end foreach
            print " </tr> ";
            //second query gets the data
            $data = $con->query($query);
            $data->setFetchMode(PDO::FETCH_ASSOC);
            foreach($data as $row){
                print " <tr> ";
                foreach ($row as $name=>$value){
                    print " <td>$value</td> ";
                } // end field loop
            print " </tr> ";
            } // end record loop
            print "</table> ";
      } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
      } // end try
    }
    if (isset($_POST['new'])) {	// Submit the update SQL command
        $result = pg_query($db, "UPDATE book SET book_id = '$_POST[bookid_updated]',  
        name = '$_POST[book_name_updated]',price = '$_POST[price_updated]',  
        date_of_publication = '$_POST[dop_updated]'");
        if (!$result) {
            echo "Update failed!!";
        } else {
            echo "Update successful!";
        }
    }
    ?>  
</body>
</html>
