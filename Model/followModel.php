<?php
require_once("../libraries/Model.php");

class FollowModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function follow($from_username, $to_username)
    {
        $result = $this->db->followProfile($from_username, $to_username);
        if ($result == 1) {
            $this->db->notifyFollow($from_username, $to_username, "$from_username ha iniziato a seguirti!");
        }
        return $result;
    }
}
?>