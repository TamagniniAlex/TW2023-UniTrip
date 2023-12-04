<?php
require_once("../model/profileModel.php");

$profile = new ProfileModel();
$count = 0;
$posts = null;

if (isset($_GET["nickname"]) && !empty($_GET["nickname"])) {
    $nickname = $_GET["nickname"];
    $data = $profile->getProfileData($nickname);
    $data['photo'] = $profile->getProfilePhoto($nickname);
    if (isset($_SESSION["nickname"])) {
        $data['following'] = $profile->isFollowing($_SESSION['nickname'], $nickname);
    }
    if (isset($_SESSION["nickname"]) && $nickname == $_SESSION['nickname']) {
        if (isset($_GET["like"]) && !empty($_GET["like"]) && $_GET["like"] == "true") {
            $posts = $profile->getPostsByAuthorLike($nickname, 10);
        } else if (isset($_GET["favourite"]) && !empty($_GET["favourite"]) && $_GET["favourite"] == "true") {
            $posts = $profile->getPostsByAuthorFavourite($nickname, 10);
        }
    }
    if ($posts == null) {
        $posts = $profile->getPostsByAuthor($nickname, 10);
    }
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