<?php
require_once("../model/followModel.php");

$follow = new FollowModel();

if (isset($_SESSION['nickname'])) {
    $id = $_GET['post_id'];
    $nickname = $_SESSION['nickname'];
    $follow->notify($nickname, $_GET['post_id']);
    echo json_encode($follow->follow($nickname, $id));
}
?>