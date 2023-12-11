<?php
require_once("../model/commentModel.php");

$comment = new CommentModel();

if (isset($_GET["post_id"]) && !empty($_GET["post_id"])) {
    if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"])) {
        echo json_encode($comment->getPostById($_GET["post_id"], $_SESSION["nickname"]));
    } else {
        echo json_encode($comment->getPostById($_GET["post_id"], ""));
    }
} else {
    echo json_encode("error");
}

?>