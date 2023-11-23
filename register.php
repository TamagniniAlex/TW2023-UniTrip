<?php
require_once("db-conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nickname"]) 
        && isset($_POST["password"]) && isset($_POST["name"]) 
        && isset($_POST["surname"]) && isset($_POST["mail"]) 
        && isset($_POST["description"]) && isset($_POST["birth-date"])) {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];
    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
    $password = hash('sha512', $password.$random_salt);
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
        $photo_url="img/profile/gray.jpg";
    }

    $sql = "INSERT INTO profile (nickname, password, salt, mail, name, surname, photo_url, description, birth_date, join_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    $salt = "";
    $stmt->bind_param("ssssssssss", $nickname, $password, $random_salt, $mail, $name, $surname, $photo_url, $description, $birth_date, $join_date);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION["nickname"] = $nickname;
        echo "Profile created successfully.";
    } else {
        echo "Failed to create profile.";
    }

    $stmt->close();
    $mysqli->close();
    
}
?>
