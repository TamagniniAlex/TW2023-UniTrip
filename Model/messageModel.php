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
}
?>