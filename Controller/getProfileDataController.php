<?php
require_once("../model/profileModel.php");

$profile = new ProfileModel();

if (isset($_GET["nickname"]) && !empty($_GET["nickname"])) {
    if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"])) {
        echo json_encode($profile->getProfileData($_GET["nickname"], $_SESSION["nickname"]));
    } else {
        echo json_encode($profile->getProfileData($_GET["nickname"], ""));
    }
} else {
    echo json_encode("error");
}

?>