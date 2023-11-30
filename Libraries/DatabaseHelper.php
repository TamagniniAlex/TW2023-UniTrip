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
            JOIN Itinerary ON Post.itinerary_id = Itinerary.id 
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
    //check if user has already liked post
    public function checkLike($nickname, $post_id) {
        $query = "SELECT COUNT(*) as likeCount FROM PostLike WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if( $result== null) return 0;
        return $result['likeCount'];
    }
    //add like to post
    public function addLike($nickname, $post_id) {
        $query = "INSERT INTO PostLike (post_id, profile_username) VALUES (?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
    }
    //remove like from post
    public function removeLike($nickname, $post_id) {
        $query = "DELETE FROM PostLike WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
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
        $query = "SELECT COUNT(*) as favouriteCount FROM PostFavourites WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if( $result== null) return 0;
        return ($result)['favouriteCount'];
    }
    //check if user has already favourited post
    public function checkFavourite($nickname, $post_id) {
        $query = "SELECT COUNT(*) as favouriteCount FROM PostFavourites WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if( $result== null) return 0;
        return $result['favouriteCount'];
    }
    //add favourite to post
    public function addFavourite($nickname, $post_id) {
        $query = "INSERT INTO PostFavourites (post_id, profile_username) VALUES (?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
    }
    //remove favourite from post
    public function removeFavourite($nickname, $post_id) {
        $query = "DELETE FROM PostFavourites WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
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