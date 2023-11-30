<?php
require_once("../libraries/Model.php");
class RegisterModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function user_exists($nickname, $email)
    {
        $count = $this->db->user_exists($nickname, $email);
        return $count;

    }
    public function insert_user($nickname, $password, $email, $name, $surname, $photo_url, $description, $birth_date, $join_date) {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $password.$random_salt);
        $this->db->insert_user($nickname, $password, $random_salt, $email, $name, $surname, $photo_url, $description, $birth_date, $join_date);
    }
}
