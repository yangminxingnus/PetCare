<?php

$conn = pg_connect("host=localhost port=5432 dbname=PetCare user=postgres password=1124");

if (!$conn) {
	die('Connection failed.??');
}
?>	