<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();
$count = 0;

//TODO mettere che se sei loggato droppa roba diversa
if (isset($_SESSION["nickname"])) {
    $photo_url = $feed->getProfilePhoto($_SESSION["nickname"]);
    $posts = $feed->getPostsFollower($_SESSION["nickname"], 10);
} else {

}

?>