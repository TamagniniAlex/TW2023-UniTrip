<?php
require_once("../model/loginModel.php");

$login = new loginModel();

$nickname_mail = $_POST['nickname_mail'];
$password = $_POST['password'];

if ($login->login($nickname_mail, $password)) {
    $_SESSION["nickname"] = $nickname_mail;
    header('location: ../view/feed.html?follow=1&nickname=' . $nickname_mail);
} else {
    header('location:../view/index.html?error=1');
}

?>