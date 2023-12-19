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
            $post['following'] = $this->db->isFollowing($nickname, $post['nickname']);
        }
        return $posts;
    }
    public function getPostsRandomLogged($nickname, $limit)
    {
        $posts = $this->db->getPostsRandomLogged($nickname, $limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
            $post['following'] = $this->db->isFollowing($nickname, $post['nickname']);
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
    public function getFavouriteCount($post_id)
    {
        return $this->db->getFavouriteCount($post_id);
    }
    public function getLikeCount($post_id)
    {
        return $this->db->getLikeCount($post_id);
    }
    public function getCommentCount($post_id)
    {
        return $this->db->getCommentCount($post_id);
    }
    public function getFollowerInformation($nickname)
    {
        return $this->db->getFollowerInformation($nickname);
    }
}
?>