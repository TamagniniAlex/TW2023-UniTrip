<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();

if(isset($_SESSION["nickname"]) && isset($_GET["nickname"]) && !empty($_GET["nickname"])) {
    echo json_encode($feed->getProfilePhoto($_GET["nickname"]));
}
?>