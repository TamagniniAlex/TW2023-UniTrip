<?php
include 'db_connect.php';
include 'functions.php';
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura
if(isset($_POST['email'], $_POST['p'])) { 
   $email = $_POST['email'];
   $password = $_POST['p']; // Recupero la password criptata.
   if(login($email, $password, $mysqli) == true) {
      echo 'Success: You have been logged in!';
   } else {
      header('Location: ./login.php?error=1');
   }
} else { 
   echo 'Invalid Request';
}
?>