<?php
require_once("../model/commentModel.php");

$comment = new CommentModel();

if (isset($_GET["post_id"]) && !empty($_GET["post_id"])) {
    echo json_encode($comment->getCommentsByPostId($_GET["post_id"]));
} else {
    echo json_encode("error");
}

?>