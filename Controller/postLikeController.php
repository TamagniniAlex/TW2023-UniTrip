<?php
require_once("../model/postLikeModel.php");

$like = new LikeModel();

$nickname = $_SESSION['nickname'];
$post_id = $_GET['post_id'];

if (isset($_SESSION['nickname'])) {
    $count = $like->checkLike($nickname, $post_id);
    if ($count > 0) {
        $like->removeLike($nickname, $post_id);
    } else {
        $like->addLike($nickname, $post_id);
    }
    //TODO togliere tutti gli header
    header("Location: ../View/feed.html?follow=1");
} else {

}

?>