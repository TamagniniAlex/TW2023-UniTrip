<?php
require_once("../model/postFavouriteModel.php");

$favourite = new FavouriteModel();

if (isset($_SESSION['nickname']) && isset($_GET['post_id'])) {
    $count = $favourite->checkFavourite($_SESSION['nickname'], $_GET['post_id']);
    if ($count > 0) {
        $favourite->removeFavourite($_SESSION['nickname'], $_GET['post_id']);
    } else {
        $favourite->notify($_SESSION['nickname'], $_GET['post_id']);
        $favourite->addFavourite($_SESSION['nickname'], $_GET['post_id']);
    }
    echo json_encode("ok");
} else {
    echo json_encode("error");
}

?>