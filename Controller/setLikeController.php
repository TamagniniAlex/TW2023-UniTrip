<?php
require_once("../model/postLikeModel.php");

$like = new LikeModel();

if (isset($_SESSION['nickname']) && isset($_GET['post_id'])) {
    $count = $like->checkLike($_SESSION['nickname'], $_GET['post_id']);
    if ($count > 0) {
        $like->removeLike($_SESSION['nickname'], $_GET['post_id']);
    } else {
        $like->addLike($_SESSION['nickname'], $_GET['post_id']);
        $like->notify($_SESSION['nickname'], $_GET['post_id']);
    }
    echo json_encode("ok");
} else {
    echo json_encode("error");
}

?>