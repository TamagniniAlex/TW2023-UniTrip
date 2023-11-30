<?php
require_once("DBHandler.php");
//create dataBaseHelper class
class DatabaseHelper {

    public $mysqli;
    public function __construct(){
        session_start();
        define("HOST", "localhost"); 
        define("USER", "secure_user"); 
        define("PASSWORD", "roHdLmnCs35P0Ssl2Q4");
        define("DATABASE", "unitrip"); 
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    }
    //get all posts
    public function getPosts($limit) {
        $query = "SELECT * FROM post  LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //get all posts follower by user
    public function getPostsFollower($nickname, $limit) {
        $query = "SELECT post.id, profile.photo_url, profile.name, profile.surname, 
            profile.nickname, post.date, post.description, post.itinerary_id FROM Post 
            JOIN Itinerary ON Post.Itinerary_id = Itinerary.id 
            JOIN Follow ON Itinerary.organizer_username = Follow.to_username 
            JOIN Profile ON Itinerary.organizer_username = Profile.nickname
            WHERE Follow.from_username = ? LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $nickname, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        //echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        return $result->fetch_all(MYSQLI_ASSOC);
    }    
    //get all posts by category
    public function getPostsByCategory($category, $limit) {
        $query = "SELECT * FROM post WHERE categoria = ?  LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $category, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //get all posts by author
    public function getPostsByAuthor($author, $limit) {
        $query = "SELECT * FROM post WHERE autore = ?  LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $author, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }
    //get all posts by author and category
    public function getPostsByAuthorAndCategory($author, $category, $limit) {
        $query = "SELECT * FROM post WHERE autore = ? AND categoria = ?  LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("ssi", $author, $category, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //given the id of a post get how many likes it has
    public function getLikeCount($post_id) {
        $query = "SELECT COUNT(*) as likeCount FROM PostLike WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if( $result== null) return 0;
        return $result['likeCount'];
    }
    //given the id of a post get how many comments it has
    public function getCommentCount($post_id) {
        $query = "SELECT COUNT(*) as commentCount FROM PostComment WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if( $result== null) return 0;
        return ($result)['commentCount'];
    }
    //given the id of a post get all it's postFavourites
    public function getFavouriteCount($post_id) {
        $query = "SELECT * FROM PostFavourites WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if( $result== null) return 0;
        return ($result)['PostFavourites'];
    }
    //given the id of a post get all it's comments
    public function getCommentsByPost($post_id) {
        $query = "SELECT * FROM PostComment WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //checks if user already exists
    public function user_exists($nickname, $email)
    {
        $query = "SELECT count(*) as users FROM Profile WHERE nickname = ? OR mail = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("ss", $nickname, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return ($result->fetch_assoc())['users'];
    }
    //inserts a new user
    public function insert_user($nickname, $password, $random_salt, $mail, $name, $surname, $photo_url, $description, $birth_date, $join_date) {
        $query = "INSERT INTO profile (nickname, password, salt, mail, name, surname, photo_url, description, birth_date, join_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->mysqli->prepare($query);
    $salt = "";
    $stmt->bind_param("ssssssssss", $nickname, $password, $random_salt, $mail, $name, $surname, $photo_url, $description, $birth_date, $join_date);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION["nickname"] = $nickname;
    }
    $stmt->close();
    return isset($_SESSION["nickname"]);
    }
}

?>