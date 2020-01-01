<?php
$dbname = "user1_rfimages";
$user = "user1_user1";
$pass = "EVrWrd6P";

$db = mysqli_connect("localhost",$user,$pass,$dbname);

mysqli_select_db($db, $dbname);
mysqli_query($db, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
?>
