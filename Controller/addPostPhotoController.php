<?php
require_once("../model/addPostModel.php");

$post = new AddPostModel();

if (isset($_SESSION["nickname"]) && isset($_POST["post_id"]) && isset($_POST["photos_url"])) {
    echo json_encode($post->addPostPhoto($_POST["post_id"], $_POST["photos_url"]));
} else {
    echo json_encode("error");
}

?>