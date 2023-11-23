<?php
require_once('db-conn.php');
require_once('DBHandler.php');
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura

if (isset($_SESSION["nickname"])) {
    $nickname = $_SESSION["nickname"];
    if($stmt = $mysqli->prepare("SELECT Post.* FROM Post 
        JOIN Trip ON Post.trip_id = Trip.id 
        JOIN Follow ON Trip.organizer_username = Follow.to_username 
        WHERE Follow.from_username = ?;")){ 
        $stmt->bind_param('s', $nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo "0 Results";
        }
        $stmt->close();
    }
} else {
    echo "Invalid Request";
}

?>
