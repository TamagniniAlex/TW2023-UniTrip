<?php
require_once("../libraries/Model.php");

class FollowModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function follow($nickname, $follower)
    {
        return $this->db->followProfile($nickname, $follower);
    }
}
?>