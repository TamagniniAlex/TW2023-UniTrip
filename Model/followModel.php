<?php
require_once("../libraries/Model.php");

class FollowModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function follow($nickname, $post_id)
    {
        return $this->db->followProfile($nickname, $post_id);
    }
    public function notify($nickname,$post_id) {
        $this->db->notify($nickname,$post_id,"$nickname ha iniziato a seguirti!"); 
    }
}
?>