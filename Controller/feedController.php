<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();

//TODO mettere che se sei loggato droppa roba diversa
if (isset($_SESSION["nickname"])) {
    $posts = $feed->getPostsFollower($_SESSION["nickname"], 10);
    $photo_url = $feed->db->getProfilePhoto($_SESSION["nickname"]);
} else {

}

?>