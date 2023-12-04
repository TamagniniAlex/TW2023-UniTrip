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

function getCommentCount($post_id)
{
    global $feed;
    return $feed->db->getCommentCount($post_id);
}
function getLikeCount($post_id)
{
    global $feed;
    return $feed->db->getLikeCount($post_id);
}
function getFavouriteCount($post_id)
{
    global $feed;
    return $feed->db->getFavouriteCount($post_id);
}
?>