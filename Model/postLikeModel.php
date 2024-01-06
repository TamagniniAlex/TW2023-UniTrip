<?php
require_once("../libraries/Model.php");

class LikeModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function checkLike($nickname, $post_id)
    {
        $count = $this->db->checkLike($nickname, $post_id);
        return $count;
    }
    public function addLike($nickname, $post_id)
    {
        $this->db->addLike($nickname, $post_id);
    }
    public function removeLike($nickname, $post_id)
    {
        $this->db->removeLike($nickname, $post_id);
    }
    public function notify($nickname, $post_id)
    {
        $this->db->notify($nickname, $post_id, "$nickname ha messo mi piace al tuo post.");
    }
}

?>