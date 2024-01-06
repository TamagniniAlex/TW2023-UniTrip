<?php
require_once("../libraries/Model.php");

class FavouriteModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function checkFavourite($nickname, $post_id)
    {
        $count = $this->db->checkFavourite($nickname, $post_id);
        return $count;
    }
    public function addFavourite($nickname, $post_id)
    {
        $this->db->addFavourite($nickname, $post_id);
    }
    public function removeFavourite($nickname, $post_id)
    {
        $this->db->removeFavourite($nickname, $post_id);
    }
    public function notify($nickname, $post_id)
    {
        $this->db->notify($nickname, $post_id, "$nickname ha salvato il tuo post nei preferiti.");
    }
}

?>