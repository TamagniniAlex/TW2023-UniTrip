<?php
require_once("../model/notificationModel.php");

$notification = new NotificationModel();

    //TODO farlo con ajax
    echo json_encode($notification->getNotifications($_GET["nickname"]));

?>