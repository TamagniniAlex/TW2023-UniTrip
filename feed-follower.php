<?php
require_once('DBHandler.php');
require_once('DatabaseHelper.php');
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura
$db = new DatabaseHelper();
$posts=$db->getPosts(2);

//TODO mettere che se sei loggato droppa roba diversa
if (isset($_SESSION["nickname"])) {
    $posts["post"] = $db->getPostsFollower($_SESSION["nickname"], 4);
    //TODO likessss
} else {

}

?>
