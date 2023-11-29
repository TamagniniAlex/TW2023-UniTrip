<?php
require_once('db-conn.php');
require_once('DBHandler.php');
sec_session_start();

// Check if all fields are set
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['nickname_mail']) || !isset($_POST['password'])) header("Location: View/login.html?error=php");

$nickname_mail = $_POST['nickname_mail'];
$password = $_POST['password'];
if (login($nickname_mail, $password, $mysqli)) {
   // Redirect to the home page with a success message
   header("Location: View/feed.php?login=success");
} else {
   // Redirect back to the login page with an error message
   header("Location: View/login.html?error=assente");
}
exit();
