<?php
require_once("../libraries/Model.php");

class ProfileModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProfilePhoto($nickname)
    {
        return $this->db->getProfilePhoto($nickname);
    }
    public function getProfileData($nickname, $follower)
    {
        $data = $this->db->getProfileData($nickname);
        $data["following"] = $this->db->isFollowing($follower, $nickname);
        return $data;
    }
    public function getPostsByAuthor($nickname, $limit)
    {
        $posts = $this->db->getPostsByAuthor($nickname, $limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
    public function getPostsByAuthorLike($nickname, $limit)
    {
        $posts = $this->db->getPostsByAuthorLike($nickname, $limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
    public function getPostsByAuthorFavourite($nickname, $limit)
    {
        $posts = $this->db->getPostsByAuthorFavourite($nickname, $limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
}
?>