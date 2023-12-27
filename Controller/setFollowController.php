<?php
require_once("../model/followModel.php");

$follow = new FollowModel();

if (isset($_SESSION['nickname']) && !empty($_SESSION['nickname']) && isset($_GET['to_username']) && !empty($_GET['to_username'])) {
    echo json_encode($follow->follow($_SESSION['nickname'], $_GET['to_username']));
} else {
    echo json_encode("error");
}

?>