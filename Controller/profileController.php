<?php
require_once("../model/profileModel.php");

$profile = new ProfileModel();
$count = 0;

if (isset($_GET["nickname"])) {
    $nickname = $_GET["nickname"];
    $data = $profile->getProfileData($nickname);
    $data['photo'] = $profile->getProfilePhoto($nickname);
    $posts = $profile->getPostsByAuthor($nickname, 10);
} else {

}

?>