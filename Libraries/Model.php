<?php

require_once('db-conn.php');
abstract class Model{
    public $db;
    public function __construct()
    {
        $this->db = new DatabaseHelper();
    }
    public function check_user ($nickname, $email) {
        return $this->db->check_user($nickname, $email);
    } 
    abstract public function insert_user($nickname, $password, $email, $name, $surname, $photo_url, $description, $birth_date, $join_date) ;
}

?>