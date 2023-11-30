<?php
require_once("../model/postFavouriteModel.php");

$favourite = new FavouriteModel();

$nickname = $_SESSION['nickname'];
$post_id = $_GET['post_id'];

if (isset($_SESSION['nickname'])) {

    $count = $favourite->checkFavourite($nickname, $post_id);

    if ($count > 0) {
        $favourite->removeFavourite($nickname, $post_id);
    }
    else {
        $favourite->addFavourite($nickname, $post_id);
    }
    header("Location: ../View/feed.php");
}
else {

}

?>