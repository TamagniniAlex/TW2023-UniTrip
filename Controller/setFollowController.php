<?php
require_once("../model/followModel.php");

$follow = new FollowModel();

if (isset($_SESSION['nickname']) && isset($_GET['to']) && !empty($_GET['to'])) {
    $nickname = $_SESSION['nickname'];
    $follower = $_GET['to'];
    echo json_encode($follow->follow($nickname, $follower));
}
?>