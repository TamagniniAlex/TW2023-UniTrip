<?php
require_once("../model/addPostModel.php");

$addPost = new AddPostModel();

if (isset($_SESSION["nickname"])) {
    $nations = $addPost->getNations();
} else {
    header("Location: login.html");
}
?>