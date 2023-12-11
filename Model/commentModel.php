<?php
require_once("../libraries/Model.php");

class CommentModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPostById($post_id)
    {
        $post = $this->db->getPostById($post_id);
        $post['photos'] = $this->db->getPostsPhoto($post_id);
        return $post;
    }
    public function getCommentsByPostId($post_id)
    {
        return $this->db->getCommentsByPostId($post_id);
    }
    public function getFollowing($nickname,$post_id)
    {
        $post = $this->getPostById($post_id);
        return $this->db->isFollowing($nickname, $post['nickname']);
    }
}

?>