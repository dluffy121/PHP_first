<?php
//Database Connection
$servername = "localhost";
$user = "root";
$password = "";
$database = "phplearndb";

$mysqli = new mysqli($servername, $user, $password, $database);
if($mysqli->connect_error){
    die("ERROR: Could not connect.".$mysqli->connect_error);
}

?>