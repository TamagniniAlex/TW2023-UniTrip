<?php
require_once("../model/registerModel.php");
require_once("../Libraries/Controller.php");
$register = new registerModel();


$password = $_POST["password"];
$nickname = $_POST["nickname"];
$name = $_POST["name"];
$surname = $_POST["surname"];
$mail = $_POST["mail"];
$description = $_POST["description"];
$birth_date = $_POST["birth-date"];
$join_date = date("Y-m-d");

if ($_FILES['image']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
    $filePngName = $_FILES["image"]["name"];
    move_uploaded_file($_FILES["image"]["tmp_name"], 'img/profile/' . $filePngName);
    $photo_url = "img/profile/" . $filePngName;
} else {
    $photo_url = "img/profile/gray.jpg";
}

$count = $register->user_exists($nickname, $mail);

if ($count > 0) {
    header('location: ../view/index.html?error=1');
}
else{
    $register->insert_user($nickname, $password, $mail, $name, $surname, $photo_url, $description, $birth_date, $join_date);
    header('location:../view/index.html?error=0');
}
exit();

function dataIsCorrect()
{
    if (isset($_POST["nickname"]) && isset($_POST["password"]) && isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["mail"]) && isset($_POST["description"]) && isset($_POST["birth-date"])) {
        return true;
    } else {
        return false;
    }
}
