<?php
require_once("../libraries/Model.php");

class AddPostModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getNations()
    {
        return $this->db->getNations();
    }
}
?>