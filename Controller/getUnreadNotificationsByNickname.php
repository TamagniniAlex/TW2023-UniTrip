<?php
require_once("../model/notificationModel.php");

$notification = new NotificationModel();

if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"])) {
    echo json_encode($notification->getUnreadNotifications($_SESSION["nickname"]));
} else {
    echo json_encode("error");
}

?>