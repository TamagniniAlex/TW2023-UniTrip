<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();

if (isset($_SESSION["nickname"])) {
    echo json_encode($feed = $feed->getFollowerInformation($_SESSION["nickname"]));
} else {
    echo json_encode("error");
}

?>