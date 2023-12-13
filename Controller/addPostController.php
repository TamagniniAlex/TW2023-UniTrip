<?php
require_once("../model/addPostModel.php");

$post = new AddPostModel();

if (isset($_SESSION["nickname"]) && isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["itinerary_id"]) && isset($_POST["country"])) {
    echo json_encode($post->addPost($_SESSION["nickname"], $_POST["title"], $_POST["description"], $_POST["itinerary_id"], $_POST["country"]));
} else {
    echo json_encode("error");
}

?>