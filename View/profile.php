<!doctype html>
<html lang="it">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Script -->
    <script src="../Controller/feedController.js"></script>

    <title>Profile</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <?php require_once("../Controller/profileController.php"); ?>
            <h1 class="text-center mb-4">UniTrip</h1>
            <div class="row mb-4">
                <div class="col-2 col-lg-1 text-center">
                    <a href="<?php echo "profile.php?nickname=" . $nickname; ?>">
                        <img src=<?php echo $data['photo']; ?> alt="Account Image" class="img-fluid rounded-circle">
                    </a>
                </div>
                <?php if (isset($_SESSION["nickname"])): ?>
                <div class="col-3 col-lg-2 offset-7 offset-lg-9 align-self-center text-center">
                    <a href="<?php echo $nickname == $_SESSION['nickname'] ? "editProfile.html" : "../Controller/followController.php?to=$nickname" ?>" class="btn btn-secondary form-control">
                    <?php
                        if ($nickname == $_SESSION['nickname']) {
                            echo "Modifica";
                        } elseif (isset($data['following']) && $data['following'] == 1) {
                            echo "Segui già";
                        } else {
                            echo "Segui";
                        }
                    ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="row mb-2">
                <h4 class="fw-bold text-start"><?php echo $data['name'] . " " . $data['surname']?></h4>
            </div>
            <div class="row mb-3">
                <h6 class="text-muted text-start">@<?php echo $nickname; ?></h6>
            </div>
            <div class="row">
                <div class="col-12">
                    <i class="fa fa-birthday-cake text-muted"> Nato il <?php echo $data['birth_date']; ?> </i>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <i class="fa fa-calendar text-muted"> Registrato il <?php echo $data['join_date']; ?> </i>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <a class="btn text-muted p-0"> <strong><?php echo $data['following_count']; ?></strong> Following</a> 
                    <a class="btn text-muted p-0 px-4"> <strong><?php echo $data['followers_count']; ?></strong> Followers</a>  
                </div>
            </div>
            <?php if (isset($_SESSION["nickname"]) && $nickname == $_SESSION['nickname']): ?>
                <div class="row mb-4 text-center">
                    <div class="col-4">
                        <a href="profile.php?nickname=<?php echo $_SESSION["nickname"] ?>" class="btn <?php echo !isset($_GET["like"]) && !isset($_GET["favourite"]) ? 'fw-bold text-decoration-underline' : ''; ?>">Posts</a>
                    </div>
                    <div class="col-4">
                        <a href="profile.php?nickname=<?php echo $_SESSION["nickname"] . "&like=true"; ?>" class="btn <?php echo isset($_GET["like"]) && $_GET["like"] == "true" ? 'fw-bold text-decoration-underline' : ''; ?>">Mi piace</a>
                    </div>
                    <div class="col-4">
                        <a href="profile.php?nickname=<?php echo $_SESSION["nickname"] . "&favourite=true"; ?>" class="btn <?php echo isset($_GET["favourite"]) && $_GET["favourite"] == "true" ? 'fw-bold text-decoration-underline' : ''; ?>">Preferiti</a>
                    </div>
                </div>
            <?php endif; ?>
            <hr>
            <div class="row mb-2 lg-text-center">
                <?php foreach ($posts as $post) : ?>
                <div class="col-12 col-lg-6 col-xxl-4 px-5">
                    <h5><?php echo $post["title"]; ?></h5>
                    <div id="carouselExampleIndicators<?php echo $count; ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php $firstPhoto = true; $count_button = 0; foreach ($post['photos'] as $photo) : ?>
                                <button type="button" data-bs-target="#carouselExampleIndicators<?php echo $count; ?>" 
                                    data-bs-slide-to="<?php echo $count_button; ?>" aria-label="Slide <?php echo $count_button++; ?>" 
                                    class="<?php echo $firstPhoto ? 'active' : ''; ?>" aria-current="<?php echo $firstPhoto ? 'true' : ''; ?>">
                                </button>
                            <?php $firstPhoto = false; endforeach; ?>
                        </div>
                        <div class="carousel-inner rounded">
                            <?php $firstPhoto = true; foreach ($post['photos'] as $photo) : ?>
                                <div class="carousel-item <?php echo $firstPhoto ? 'active' : ''; ?>">
                                    <img src="<?php echo $photo['photo_url']?>" class="d-block w-100" alt="Post image">
                                </div>
                            <?php $firstPhoto = false; endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators<?php echo $count; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators<?php echo $count++; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!--TODO hashtag-->
                    <div class="row mb-2">
                        <p class="lh-sm"><?php echo $post['description'] ?></p>
                    </div>
                    <div class="row mb-4">
                        <div class="col-1">
                            <a href="itinerary.php?itinerary_id=<?php echo $post['itinerary_id']; ?>" class="btn text-muted p-0">
                                <i class="fa fa-map-o"></i>
                            </a>                        
                        </div>
                        <div class="col-3 text-end p-0">
                            <a href="comment.html?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                                <i class="fa fa-comment-o"></i>
                                <?php $comments = getCommentCount($post['id']); echo $comments; ?>
                            </a>                        
                        </div>
                        <div class="col-4 text-center p-0">
                            <button id="likesCount<?php echo $post['id']; ?>" class="btn text-muted p-0" onclick="setLike(<?php echo $post['id']; ?>)">
                                <i class="fa fa-heart-o"></i> 
                            </button>                    
                        </div>
                        <div class="col-3 text-start p-0">
                            <button id="starsCount<?php echo $post['id']; ?>" class="btn text-muted p-0" onclick="setFavourite(<?php echo $post['id']; ?>)">
                                <i class="fa fa-star-o"></i> 
                            </button>                      
                        </div>
                        <div class="col-1 p-0">
                            <a href="#" class="btn text-muted p-0"><i class="fa fa-share"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>