<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();
$count = 0;

if (isset($_SESSION["nickname"])) {
    $photo_url = $feed->getProfilePhoto($_SESSION["nickname"]);
    if (isset($_GET["follow"])) {
        $posts = $feed->getPostsFollower($_SESSION["nickname"], 10);
    } else {
        $posts = $feed->getPostsRandomLogged($_SESSION["nickname"], 10);
    }
} else {
    if (isset($_GET["follow"])) {
        header("Location: login.html");
    } else {
        $posts = $feed->getPostsRandom(10);
    }
}

?>