<?php 

$host = "localhost";
$dbname = "markers";
$port = "5432";
$user = "postgres";
$password = "sapienza";

$conn = pg_connect("host=localhost dbname = $dbname port =$port user =$user password = $password");

if (!$conn) { // Check Connection
    die("<script>alert('Connection Failed.')</script>");
}

?>