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
        return $this->db->getPostById($post_id);
    }
    public function getCommentsByPostId($post_id)
    {
        return $this->db->getCommentsByPostId($post_id);
    }
}

?>