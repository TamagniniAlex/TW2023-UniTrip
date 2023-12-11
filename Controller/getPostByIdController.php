<?php
require_once("../model/commentModel.php");

$comment = new CommentModel();
echo json_encode($comment->getPostById($_GET["post_id"]));
    
?>