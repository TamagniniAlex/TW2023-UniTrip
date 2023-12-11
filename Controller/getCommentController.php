<?php
require_once("../model/commentModel.php");

$comment = new CommentModel();
    echo json_encode($comment->getCommentsByPostId($_GET["post_id"]));
?>