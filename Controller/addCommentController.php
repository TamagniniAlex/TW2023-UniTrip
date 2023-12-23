<?php
require_once("../model/commentModel.php");

$comment = new CommentModel();

if (isset($_POST["post_id"]) && !empty($_POST["post_id"]) && isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"]) && isset($_POST["comment"]) && !empty($_POST["comment"])) {
    $comment->notify($_SESSION["nickname"], $_POST["post_id"], $_POST["comment"]);
    echo json_encode($comment->postComment($_SESSION["nickname"], $_POST["post_id"], $_POST["comment"]));
} else {
    echo json_encode("error");
}

?>