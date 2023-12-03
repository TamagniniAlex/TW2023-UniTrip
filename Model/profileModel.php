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
    public function getProfileData($nickname)
    {
        return $this->db->getProfileData($nickname);
    }
    public function getPostsByAuthor($nickname, $limit)
    {
        $posts = $this->db->getPostsByAuthor($nickname, $limit);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
}

?>