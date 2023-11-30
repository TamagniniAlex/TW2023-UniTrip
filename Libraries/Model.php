<?php
require_once("../libraries/DatabaseHelper.php");
abstract class Model{
    public $db;
    public function __construct()
    {
        $this->db = new DatabaseHelper();
    }
    public function user_exists ($nickname, $email) {
        return $this->db->user_exists($nickname, $email);
    } 
}

?>