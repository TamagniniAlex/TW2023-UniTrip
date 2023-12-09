<?php
require_once("../libraries/Model.php");

class CommentModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPostById($nickname, $post_id)
    {
        $post = $this->db->getPostById($post_id);
        $post['photos'] = $this->db->getPostsPhoto($post_id);
        $post['following'] = $this->db->isFollowing($nickname, $post['nickname']);
        return $post;
    }
    public function getCommentsByPostId($post_id)
    {
        return $this->db->getCommentsByPostId($post_id);
    }
}

?>