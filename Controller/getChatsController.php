<?php
require_once("../model/messageModel.php");

$message = new MessageModel();

if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"])) {
    echo json_encode($message->getChatsAndLastMessage($_SESSION["nickname"]));
} else {
    echo json_encode("error");
}

?>