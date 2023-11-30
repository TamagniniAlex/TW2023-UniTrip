<?php
require_once("../model/feedModel.php");

$feed = new FeedModel();
$posts =[];
//TODO mettere che se sei loggato droppa roba diversa
if (isset($_SESSION["nickname"])) {
    $posts = $feed->getPostsFollower($_SESSION["nickname"], 4);
    //TODO likessss
    //TODO in che senso ?
} else {

}
?>