<?php
require_once("../libraries/Model.php");

class NotificationModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getNotifications($nickname)
    {
        return $this->db->getNotifications($nickname);
    }
    public function getUnreadNotifications($nickname)
    {
        return $this->db->getUnreadNotifications($nickname);
    }
}
?>