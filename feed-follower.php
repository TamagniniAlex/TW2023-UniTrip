<?php
require_once('DBHandler.php');
require_once('DatabaseHelper.php');
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura
$db = new DatabaseHelper();

//TODO mettere che se sei loggato droppa roba diversa
if (isset($_SESSION["nickname"])) {
    $posts = $db->getPostsFollower($_SESSION["nickname"], 4);
    //TODO likessss
} else {

}

?>
