<?php
require_once ('db-conn.php');
require_once('DBHandler.php');
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura
$email="";
var_dump($_SESSION);
if(isset($_POST['email'], $_POST['password'])) {
   $email = $_POST['email'];
   $password = $_POST['password']; // Recupero la password criptata.
   if( login($email, $password, $mysqli)) {
      echo 'Success: You have been logged in!';
   } else {
      header('Location: ./login.php?error=1');
   }
} else { 
   echo 'Invalid Request';
}

$_SESSION["login"] = $email;
?>