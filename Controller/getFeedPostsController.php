<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();
$count = 0;

if (isset($_SESSION["nickname"])) {
    if (isset($_GET["follow"])) {
        echo json_encode($posts = $feed->getPostsFollower($_SESSION["nickname"]));
    } else {
        echo json_encode($posts = $feed->getPostsRandomLogged($_SESSION["nickname"]));
    }
} else {
    if (isset($_GET["follow"])) {
        echo json_encode("notlogged");
    } else {
        echo json_encode($posts = $feed->getPostsRandom());
    }
}

?>