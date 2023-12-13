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
    public function getCitiesByNation($nation)
    {
        return $this->db->getCitiesByNation($nation);
    }
    public function addPost($author, $title, $description, $itinerary_id, $country)
    {
        $post_id = $this->db->addPost($author, $title, $description, $itinerary_id, $country);
        if ($post_id) {
            return $post_id;
        }
        return "error";
    }
    public function addPostPhoto($post_id, $photos_url)
    {
        foreach ($photos_url as $photo_url) {
            if (!$this->db->addPostPhoto($post_id, $photo_url)) {
                return "error";
            }
        }
        return "success";
    }
    public function uploadPhoto($files, $post_id)
    {
        $targetDir = "../img/post/";
        $uploadedFiles = [];
        foreach ($files["name"] as $key => $value) {
            $count = $key + 1;
            $newFileName = $post_id . "_" . $count . "." . pathinfo($value)['extension'];
            $targetFilePath = $targetDir . $newFileName;
            move_uploaded_file($files["tmp_name"][$key], $targetFilePath);
            $uploadedFiles[] = $targetFilePath;
        }
        return $uploadedFiles;
    }
}
?>