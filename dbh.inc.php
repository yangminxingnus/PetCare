<?php

$conn = pg_connect("host=localhost port=5432 dbname=PetCare user=postgres password=19980Ymx");

if (!$conn) {
	die('Connection failed.??');
}
?>	