<?php
require_once("../libraries/Model.php");

class FeedModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPostsFollower($nickname, $limit)
    {
        return $this->db->getPostsFollower($nickname, $limit);
    }
    public function getProfilePhoto($nickname)
    {
        return $this->db->getProfilePhoto($nickname);
    }
    public function getPostsPhoto($id)
    {
        return $this->db->getPostsPhoto($id);
    }
}

?>