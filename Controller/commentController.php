<?php
require_once("../model/commentModel.php");

$comment = new CommentModel();

$comments = [];
$count = 0;
$nickname = null;

if (isset($_GET["post_id"]) && !empty($_GET["post_id"])) {
    $post_id = $_GET["post_id"];
    if(isset($_SESSION["nickname"])){
        $nickname = $_SESSION["nickname"];
    }
    $post = $comment->getPostById($nickname, $post_id);
    $comments = $comment->getCommentsByPostId($post_id);
} else {
    header("Location: feed.php");
}

?>