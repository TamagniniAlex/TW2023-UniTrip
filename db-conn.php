<?php 
define("HOST", "localhost"); 
define("USER", "secure_user"); 
define("PASSWORD", "roHdLmnCs35P0Ssl2Q4");
define("DATABASE", "unitrip"); 
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
?>