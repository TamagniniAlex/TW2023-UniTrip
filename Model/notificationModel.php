<?php
require_once("../libraries/Model.php");

class NotificationModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getNotifications()
    {
        return $this->db->getNotifications();
    }
    public function getUnreadNotifications()
    {
        return $this->db->getUnreadNotifications();
    }
}
?>