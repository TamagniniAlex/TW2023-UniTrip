<?php
require_once("../libraries/Model.php");

class MessageModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function addMessagePost($from_username, $to_username, $message, $post_id)
    {
        return $this->db->addMessagePost($from_username, $to_username, $message, $post_id);
    }
    public function addMessageChat($from_username, $to_username, $message)
    {
        return $this->db->addMessageChat($from_username, $to_username, $message);
    }
    public function getChatsAndLastMessage($nickname)
    {
        return $this->db->getChatsLastMessage($nickname);
    }
    public function getChatsAll($nickname, $chat_with)
    {
        return $this->db->getChatsAll($nickname, $chat_with);
    }
    public function sendNotification($from_username, $to_username, $message)
    {
        return $this->db->notifyDirectMessage($from_username, $to_username, $message);
    }
}
?>