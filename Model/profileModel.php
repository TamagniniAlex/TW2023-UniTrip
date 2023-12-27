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
        if (empty($data)) {
            return "error";
        }
        $data["following"] = $this->db->isFollowing($follower, $nickname);
        return $data;
    }
    public function getPostsByAuthor($nickname)
    {
        $posts = $this->db->getPostsByAuthor($nickname);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
    public function getPostsByAuthorLike($nickname)
    {
        $posts = $this->db->getPostsByAuthorLike($nickname);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
    public function getPostsByAuthorFavourite($nickname)
    {
        $posts = $this->db->getPostsByAuthorFavourite($nickname);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
}
?>