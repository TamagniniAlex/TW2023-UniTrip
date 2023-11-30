<?php
require_once("../model/commentModel.php");

$comment = new CommentModel();

$comments = [];

if (isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];
    $post = $comment->getPostById($post_id);
    $comments = $comment->getCommentsByPostId($post_id);
} else {

}

?>