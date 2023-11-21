<?php

require_once("db-conn.php");

$post_id = $_POST['post_id']; 
$profile_nickname = $_SESSION['nickname'];

if (empty($post_id) || empty($profile_nickname)){
    echo "Error: Empty data.";
    exit();
} else {
    $sql = "INSERT INTO PostFavourites (post_id, profile_username) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $post_id, $profile_nickname);

    if ($stmt->execute()) {
        echo "Favourite added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
