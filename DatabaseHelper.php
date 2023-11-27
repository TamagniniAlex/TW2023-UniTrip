<?php
require_once("DBHandler.php");
//create dataBaseHelper class
class DatabaseHelper {

    private $mysqli;
    public function __construct(){
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
}

?>