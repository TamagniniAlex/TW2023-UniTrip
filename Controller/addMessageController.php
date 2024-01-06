<?php
require_once("../model/messageModel.php");

$message = new MessageModel();

if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"]) && isset($_POST["to_username"]) && !empty($_POST["to_username"])
        && isset($_POST["message"]) && !empty($_POST["message"]) && isset($_POST["post_id"]) && !empty($_POST["post_id"])) {
            $message->sendNotificationPost($_SESSION["nickname"], $_POST["to_username"], $_POST["message"], $_POST["post_id"]);
            echo json_encode($message->addMessagePost($_SESSION["nickname"], $_POST["to_username"], $_POST["message"], $_POST["post_id"]));
} else if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"]) && isset($_POST["to_username"]) && !empty($_POST["to_username"])
        && isset($_POST["message"]) && !empty($_POST["message"])) {
            $message->sendNotification($_SESSION["nickname"], $_POST["to_username"], $_POST["message"]);
            echo json_encode($message->addMessageChat($_SESSION["nickname"], $_POST["to_username"], $_POST["message"]));
} else {
    echo json_encode("error");
}

?>