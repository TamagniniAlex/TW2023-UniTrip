<?php
require_once("../model/postLikeModel.php");
$like = new LikeModel();

if (isset($_SESSION['nickname']) && isset($_GET['post_id'])) {
    $count = $like->checkLike($_SESSION['nickname'], $_GET['post_id']);
    if ($count > 0) {
        echo json_encode("1");
        exit();
    }
}
echo json_encode("0");
exit();

?>