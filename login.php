<?php
require_once('db-conn.php');
require_once('DBHandler.php');
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nickname_mail']) && isset($_POST['password'])) {
   $nickname_mail = $_POST['nickname_mail'];
   $password = $_POST['password'];
   if(login($nickname_mail, $password, $mysqli)) {
      echo 'Success: You have been logged in!';
   } else {
      echo 'Invalid Credentials';
   }
} else { 
   echo 'Invalid Request';
}

?>