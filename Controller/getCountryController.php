<?php
require_once("../model/addPostModel.php");

$addPost = new AddPostModel();

if (isset($_SESSION["nickname"])) {
    echo json_encode($addPost->getNations());
} else {
    header("Location: login.html");
}
?>