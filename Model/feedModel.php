<?php
require_once("../libraries/Model.php");

class FeedModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProfilePhoto($nickname)
    {
        return $this->db->getProfilePhoto($nickname);
    }
    public function getPostsFollower($nickname, $limit)
    {
        $posts = $this->db->getPostsFollower($nickname, $limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
    public function getPostsRandomLogged($nickname, $limit)
    {
        $posts = $this->db->getPostsRandomLogged($nickname, $limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
    public function getPostsRandom($limit)
    {
        $posts = $this->db->getPostsRandom($limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
}

?>