<?php
require_once("../model/profileModel.php");

$profile = new ProfileModel();

if (isset($_GET["nickname"]) && !empty($_GET["nickname"])) {
    if (isset($_SESSION["nickname"]) && $_GET["nickname"] == $_SESSION['nickname']) {
        if (isset($_GET["like"]) && !empty($_GET["like"]) && $_GET["like"] == "true") {
            echo json_encode($profile->getPostsByAuthorLike($_GET["nickname"], 10));
        } else if (isset($_GET["favourite"]) && !empty($_GET["favourite"]) && $_GET["favourite"] == "true") {
            echo json_encode($profile->getPostsByAuthorFavourite($_GET["nickname"], 10));
        } else {
            echo json_encode($profile->getPostsByAuthor($_GET["nickname"], 10));
        }
    } else {
        echo json_encode($profile->getPostsByAuthor($_GET["nickname"], 10));
    }
} else {
    echo json_encode("error");
}

?>