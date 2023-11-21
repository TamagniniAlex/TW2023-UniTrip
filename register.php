<?php

require_once("db-conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $mail = $_POST["mail"];
    $description = $_POST["description"];
    $birth_date = $_POST["birth-date"];
    $join_date = date("Y-m-d");

    $filePngName = $_FILES["image"]["name"];
    if (isset($_FILES['image'])) {
        move_uploaded_file($_FILES["image"]["tmp_name"], 'img/profile/' . $filePngName);
        $photo_url = "img/profile/" . $filePngName;
    } else {
        $photo_url="img/profile/gray.jpg";
    }

    $sql = "INSERT INTO profile (nickname, password, salt, mail, name, surname, photo_url, description, birth_date, join_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssssss", $nickname, $password, $random_salt, $mail, $name, $surname, $photo_url, $description, $birth_date, $join_date);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Profile created successfully.";
    } else {
        echo "Failed to create profile.";
    }

    $stmt->close();
    $mysqli->close();
}

?>
