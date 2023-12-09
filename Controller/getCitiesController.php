<?php
require_once("../model/addPostModel.php");

$addPost = new AddPostModel();

if (isset($_SESSION["nickname"]) && isset($_GET["nation"]) && !empty($_GET["nation"])) {
    echo json_encode($addPost->getCitiesByNation($_GET["nation"]));
} else {
    header("Location: login.html");
}
?>