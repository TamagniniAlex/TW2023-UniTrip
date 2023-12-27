<?php
require_once("../model/notificationModel.php");

$notification = new NotificationModel();

echo json_encode($notification->getNotifications());
?>