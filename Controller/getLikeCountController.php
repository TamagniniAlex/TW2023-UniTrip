<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();

if (isset($_GET["post_id"]) && !empty($_GET["post_id"])) {
    echo json_encode($feed->getLikeCount($_GET["post_id"]));
}
?>