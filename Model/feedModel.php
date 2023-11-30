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
}


?>