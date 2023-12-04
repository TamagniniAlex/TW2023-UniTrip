<?php
require_once("DBHandler.php");
//create dataBaseHelper class
class DatabaseHelper
{
    public $mysqli;
    public function __construct()
    {
        session_start();
        define("HOST", "localhost");
        define("USER", "secure_user");
        define("PASSWORD", "roHdLmnCs35P0Ssl2Q4");
        define("DATABASE", "unitrip");
        $this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    }
    //change datetime format array
    function formatDateArray($array)
    {
        foreach ($array as &$value) {
            $datetime_value = new DateTime($value['datetime']);
            $datetime_now = new DateTime();
            $diff = $datetime_now->diff($datetime_value);
            if ($diff->y > 0) {
                $result = $diff->y . " anni";
            } elseif ($diff->m > 0) {
                $result = $diff->m . " mesi";
            } elseif ($diff->d > 0) {
                $result = $diff->d . " giorni";
            } elseif ($diff->h > 0) {
                $result = $diff->h . " ore";
            } elseif ($diff->i > 0) {
                $result = $diff->i . " minuti";
            } else {
                $result = $diff->s . " secondi";
            }
            $value['datetime'] = $result;
        }
        return $array;
    }
    //change datetime format single
    function formatDateSingle($value)
    {
        $datetime_value = new DateTime($value['datetime']);
        $datetime_now = new DateTime();
        $diff = $datetime_now->diff($datetime_value);
        if ($diff->y > 0) {
            $result = $diff->y . " anni";
        } elseif ($diff->m > 0) {
            $result = $diff->m . " mesi";
        } elseif ($diff->d > 0) {
            $result = $diff->d . " giorni";
        } elseif ($diff->h > 0) {
            $result = $diff->h . " ore";
        } elseif ($diff->i > 0) {
            $result = $diff->i . " minuti";
        } else {
            $result = $diff->s . " secondi";
        }
        $value['datetime'] = $result;
        return $value;
    }
    //change date format
    function formatDate($data)
    {
        $monthsItalian = [
            '01' => 'Gennaio',
            '02' => 'Febbraio',
            '03' => 'Marzo',
            '04' => 'Aprile',
            '05' => 'Maggio',
            '06' => 'Giugno',
            '07' => 'Luglio',
            '08' => 'Agosto',
            '09' => 'Settembre',
            '10' => 'Ottobre',
            '11' => 'Novembre',
            '12' => 'Dicembre',
        ];
        $birthDate = DateTime::createFromFormat('Y-m-d', $data['birth_date']);
        if ($birthDate !== false) {
            $monthNumber = $birthDate->format('m');
            $data['birth_date'] = $birthDate->format('d') . ' ' . $monthsItalian[$monthNumber] . ' ' . $birthDate->format('Y');
        }
        $joinDate = DateTime::createFromFormat('Y-m-d', $data['join_date']);
        if ($joinDate !== false) {
            $monthNumber = $joinDate->format('m');
            $data['join_date'] = $joinDate->format('d') . ' ' . $monthsItalian[$monthNumber] . ' ' . $joinDate->format('Y');
        }
        return $data;
    }
    //get profile photo
    public function getProfilePhoto($nickname)
    {
        $query = "SELECT photo_url FROM Profile WHERE nickname = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($row = $result->fetch_assoc()) {
            return $row['photo_url'];
        } else {
            return '../img/profile/gray.jpg';
        }
    }
    //get profile data
    public function getProfileData($nickname)
    {
        $query = "SELECT profile.name, profile.surname, profile.description, profile.birth_date, 
            profile.join_date, COUNT(follower.from_username) AS followers_count, 
            COUNT(following.to_username) AS following_count FROM Profile profile
            LEFT JOIN Follow follower ON profile.nickname = follower.to_username
            LEFT JOIN Follow following ON profile.nickname = following.from_username
            WHERE profile.nickname = ? GROUP BY profile.nickname;";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->formatDate($result->fetch_assoc());
    }
    //get post by post_id
    public function getPostById($id)
    {
        $query = "SELECT profile.photo_url, profile.name, profile.surname, 
            profile.nickname, post.datetime, post.title, post.description, post.itinerary_id FROM Post 
            JOIN Profile ON Post.author = Profile.nickname WHERE Post.id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->formatDateSingle($result->fetch_assoc());
    }
    //get all posts
    public function getPosts($limit)
    {
        $query = "SELECT * FROM post LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //get all posts follower by user
    public function getPostsFollower($nickname, $limit)
    {
        $query = "SELECT post.id, profile.photo_url, profile.name, profile.surname, 
            profile.nickname, post.datetime, post.title, post.description, post.itinerary_id FROM Post 
            JOIN Itinerary ON Post.itinerary_id = Itinerary.id 
            JOIN Follow ON Itinerary.organizer_username = Follow.to_username 
            JOIN Profile ON Itinerary.organizer_username = Profile.nickname
            WHERE Follow.from_username = ? ORDER BY post.datetime DESC LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $nickname, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->formatDateArray($result->fetch_all(MYSQLI_ASSOC));
    }
    //get all posts random logged in
    public function getPostsRandomLogged($nickname, $limit)
    {
        $query = "SELECT post.id, profile.photo_url, profile.name, profile.surname, 
            profile.nickname, post.datetime, post.title, post.description, post.itinerary_id FROM Post 
            JOIN Itinerary ON Post.itinerary_id = Itinerary.id 
            JOIN Follow ON Itinerary.organizer_username = Follow.to_username 
            JOIN Profile ON Itinerary.organizer_username = Profile.nickname
            WHERE Profile.nickname != ? ORDER BY RAND() DESC LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $nickname, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->formatDateArray($result->fetch_all(MYSQLI_ASSOC));
    }
    //get all posts random
    public function getPostsRandom($limit)
    {
        $query = "SELECT post.id, profile.photo_url, profile.name, profile.surname, 
                profile.nickname, post.datetime, post.title, post.description, post.itinerary_id FROM Post 
                JOIN Itinerary ON Post.itinerary_id = Itinerary.id 
                JOIN Follow ON Itinerary.organizer_username = Follow.to_username 
                JOIN Profile ON Itinerary.organizer_username = Profile.nickname
                ORDER BY RAND() DESC LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->formatDateArray($result->fetch_all(MYSQLI_ASSOC));
    }
    //get all posts by category
    public function getPostsByCategory($category, $limit)
    {
        $query = "SELECT * FROM post WHERE categoria = ?  LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $category, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //get all posts by author
    public function getPostsByAuthor($author, $limit)
    {
        $query = "SELECT * FROM post WHERE author = ?  LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("si", $author, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //get all posts by author and category
    public function getPostsByAuthorAndCategory($author, $category, $limit)
    {
        $query = "SELECT * FROM post WHERE autore = ? AND categoria = ?  LIMIT ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("ssi", $author, $category, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //get all Posts Photo
    public function getPostsPhoto($id)
    {
        $query = "SELECT photo_url FROM PostPhoto WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //given the id of a post get how many likes it has
    public function getLikeCount($post_id)
    {
        $query = "SELECT COUNT(*) as likeCount FROM PostLike WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if ($result == null)
            return 0;
        return $result['likeCount'];
    }
    //check if user has already liked post
    public function checkLike($nickname, $post_id)
    {
        $query = "SELECT COUNT(*) as likeCount FROM PostLike WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if ($result == null)
            return 0;
        return $result['likeCount'];
    }
    //add like to post
    public function addLike($nickname, $post_id)
    {
        $query = "INSERT INTO PostLike (post_id, profile_username) VALUES (?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
    }
    //remove like from post
    public function removeLike($nickname, $post_id)
    {
        $query = "DELETE FROM PostLike WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
    }
    //given the id of a post get how many comments it has
    public function getCommentCount($post_id)
    {
        $query = "SELECT COUNT(*) as commentCount FROM PostComment WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if ($result == null)
            return 0;
        return ($result)['commentCount'];
    }
    //get Comments By Post Id 
    public function getCommentsByPostId($post_id)
    {
        $query = "SELECT profile.photo_url, profile.name, profile.surname, 
            profile.nickname, postcomment.datetime, postcomment.comment FROM Postcomment 
            JOIN Profile ON Postcomment.author = Profile.nickname WHERE Postcomment.post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->formatDateArray($result->fetch_all(MYSQLI_ASSOC));
    }
    //given the id of a post get all it's postFavourites
    public function getFavouriteCount($post_id)
    {
        $query = "SELECT COUNT(*) as favouriteCount FROM PostFavourites WHERE post_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if ($result == null)
            return 0;
        return ($result)['favouriteCount'];
    }
    //check if user has already favourited post
    public function checkFavourite($nickname, $post_id)
    {
        $query = "SELECT COUNT(*) as favouriteCount FROM PostFavourites WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        if ($result == null)
            return 0;
        return $result['favouriteCount'];
    }
    //add favourite to post
    public function addFavourite($nickname, $post_id)
    {
        $query = "INSERT INTO PostFavourites (post_id, profile_username) VALUES (?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
    }
    //remove favourite from post
    public function removeFavourite($nickname, $post_id)
    {
        $query = "DELETE FROM PostFavourites WHERE post_id = ? AND profile_username = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("is", $post_id, $nickname);
        $stmt->execute();
        $stmt->close();
    }
    //given the id of a post get all it's comments
    public function getCommentsByPost($post_id)
    {
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
    public function insert_user($nickname, $password, $random_salt, $mail, $name, $surname, $photo_url, $description, $birth_date, $join_date)
    {
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
    //get itinerary information
    public function getItineraryInformation($itinerary_id)
    {
        $query = "SELECT Profile.name, Profile.surname, Itinerary.organizer_username, Itinerary.description FROM Itinerary 
            JOIN Profile ON Itinerary.organizer_username = Profile.nickname WHERE Itinerary.id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $itinerary_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }
    //get itinerary between cities
    public function getItineraryBetweenCities($itinerary_id)
    {
        $query = "SELECT * FROM ItineraryBetweenCities WHERE itinerary_id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("i", $itinerary_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    //get nations
    public function getNations()
    {
        $query = "SELECT * FROM Country ORDER BY name ASC";
        $stmt = $this->mysqli->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>