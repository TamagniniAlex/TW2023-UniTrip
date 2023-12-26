<?php
require_once("../model/messageModel.php");

$message = new MessageModel();

if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"]) && isset($_GET["chat_with"]) && !empty($_GET["chat_with"])) {
    echo json_encode($message->getChatsAll($_SESSION["nickname"], $_GET["chat_with"]));
} else {
    echo json_encode("error");
}

?>