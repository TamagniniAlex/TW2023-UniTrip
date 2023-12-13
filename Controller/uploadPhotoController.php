<?php
require_once("../model/addPostModel.php");

$photo = new AddPostModel();

if (isset($_SESSION["nickname"]) && isset($_FILES["file"]) && isset($_GET["post_id"])) {
    echo json_encode($photo->uploadPhoto($_FILES["file"], $_GET["post_id"]));
} else {
    echo json_encode("error");
}

?>