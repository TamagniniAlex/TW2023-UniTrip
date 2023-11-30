<?php
require_once("../libraries/Model.php");
require_once("../Libraries/DBHandler.php");

class LoginModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function user_exists($nickname, $password)
    {
        $count = $this->db->user_exists($nickname, $password);
        return $count;

    }
    public function login($nickname_mail, $password)
    {
        return login($nickname_mail, $password, $this->db->mysqli);
    }
}


?>