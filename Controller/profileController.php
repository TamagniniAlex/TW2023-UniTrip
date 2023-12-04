<?php
require_once("../model/profileModel.php");

$profile = new ProfileModel();
$count = 0;

if (isset($_GET["nickname"]) && !empty($_GET["nickname"])) {
    $nickname = $_GET["nickname"];
    $data = $profile->getProfileData($nickname);
    $data['photo'] = $profile->getProfilePhoto($nickname);
    $posts = $profile->getPostsByAuthor($nickname, 10);
} else {
    header("Location: feed.php");
}

function getCommentCount($post_id)
{
    global $profile;
    return $profile->db->getCommentCount($post_id);
}
function getLikeCount($post_id)
{
    global $profile;
    return $profile->db->getLikeCount($post_id);
}
function getFavouriteCount($post_id)
{
    global $profile;
    return $profile->db->getFavouriteCount($post_id);
}

?>