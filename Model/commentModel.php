<?php
require_once("../libraries/Model.php");

class CommentModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPostById($post_id, $nickname)
    {
        $post = $this->db->getPostById($post_id);
        if (empty($post)) {
            return "error";
        }
        $post['photos'] = $this->db->getPostsPhoto($post_id);
        if ($nickname != "") {
            $post['following'] = $this->db->isFollowingByPost($nickname, $post_id);
        } else {
            $post['following'] = -1;
        }
        return $post;
    }
    public function getCommentsByPostId($post_id)
    {
        return $this->db->getCommentsByPostId($post_id);
    }
    public function postComment($nickname, $post_id, $comment)
    {
        return $this->db->postComment($nickname, $post_id, $comment);
    }
    public function notify($nickname, $post_id, $comment)
    {
        $this->db->notify($nickname, $post_id, "$nickname dice: $comment");
    }
}

?>