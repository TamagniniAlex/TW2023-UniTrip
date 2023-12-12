<?php
require_once("../libraries/Model.php");

class SearchModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPartialSearch($text)
    {
        $posts = $this->db->getPartialSearch($text);
        foreach ($posts as &$post) {
            $post['photos'] = $this->db->getPostsPhoto($post['id']);
        }
        return $posts;
    }
}
?>