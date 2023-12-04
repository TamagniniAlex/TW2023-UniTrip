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
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>Feed</title>
    </head>

    <body>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <?php require_once("../Controller/feedController.php"); ?>
                <h1 class="text-center mb-4">UniTrip</h1>
                <div class="row mb-4">
                    <?php if (isset($_SESSION["nickname"])): ?>
                        <div class="col-2 col-lg-1 text-center">
                            <a href="profile.php?nickname=<?php echo $_SESSION["nickname"]; ?>">
                                <img src="<?php echo $photo_url; ?>" alt="Account Image" class="img-fluid rounded-circle">
                            </a>
                        </div>
                    <?php endif; ?>
                    <div
                        class="col-<?php echo isset($_SESSION["nickname"]) ? '4 col-lg-5' : '6'; ?> align-self-center text-end">
                        <a href="feed.php"
                            class="btn <?php echo !isset($_GET["follow"]) ? 'fw-bold text-decoration-underline' : ''; ?>">Suggeriti</a>
                    </div>
                    <div
                        class="col-<?php echo isset($_SESSION["nickname"]) ? '4 col-lg-5' : '6'; ?> align-self-center text-justify">
                        <a href="feed.php?follow=1"
                            class="btn <?php echo isset($_GET["follow"]) ? 'fw-bold text-decoration-underline' : ''; ?>">Seguiti</a>
                    </div>
                    <?php if (isset($_SESSION["nickname"])): ?>
                        <div class="col-2 col-lg-1 align-self-center text-center fs-3">
                            <a href="profile.php?nickname=<?php echo $_SESSION["nickname"] . "&favourite=true"; ?>"
                                class="text-dark"><i class="fa fa-star-o"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
                <hr>

                <!--Dynamic Posts-->
                <?php foreach ($posts as $post): ?>
                    <div class="row mb-2">
                        <div class="col-2 col-lg-1 text-center">
                            <a href="<?php echo "profile.php?nickname=" . $post['nickname']; ?>">
                                <img src=<?php echo $post['photo_url']; ?> alt="Account Image"
                                    class="img-fluid rounded-circle">
                            </a>
                        </div>
                        <div class="col-7 col-lg-9 align-self-center">
                            <a href="<?php echo "profile.php?nickname=" . $post['nickname']; ?>" class="btn p-0">
                                <?php echo $post['name'] . " " . $post['surname'] ?>
                            </a>
                            <a href="<?php echo "profile.php?nickname=" . $post['nickname']; ?>"
                                class="btn text-muted p-0">@
                                <?php echo $post['nickname'] ?>
                            </a>
                            <a class="btn disabled text-muted p-0 px-3">&#9679
                                <?php echo $post['datetime'] ?>
                            </a>
                        </div>
                        <?php if (isset($_SESSION["nickname"])): ?>
                            <div class="col-3 col-lg-2 align-self-center text-center">
                                <a href="<?php echo "../Controller/followController.php?to=" . $post['nickname'] ?>" class="btn btn-secondary form-control">
                                    <?php
                                    if (isset($post['following']) && $post['following'] == 1) {
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
                        <div class="col-10 col-lg-11 align-self-center ms-auto">
                            <h5>
                                <?php echo $post['title'] ?>
                            </h5>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-10 col-lg-11 align-self-center ms-auto">
                            <div id="carouselExampleIndicators<?php echo $count; ?>" class="carousel slide"
                                data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <?php $firstPhoto = true;
                                    $count_button = 0;
                                    foreach ($post['photos'] as $photo): ?>
                                        <button type="button" data-bs-target="#carouselExampleIndicators<?php echo $count; ?>"
                                            data-bs-slide-to="<?php echo $count_button; ?>"
                                            aria-label="Slide <?php echo $count_button++; ?>"
                                            class="<?php echo $firstPhoto ? 'active' : ''; ?>"
                                            aria-current="<?php echo $firstPhoto ? 'true' : ''; ?>">
                                        </button>
                                        <?php $firstPhoto = false; endforeach; ?>
                                </div>
                                <div class="carousel-inner rounded">
                                    <?php $firstPhoto = true;
                                    foreach ($post['photos'] as $photo): ?>
                                        <div class="carousel-item <?php echo $firstPhoto ? 'active' : ''; ?>">
                                            <img src="<?php echo $photo['photo_url'] ?>" class="d-block w-100" alt="Post image">
                                        </div>
                                        <?php $firstPhoto = false; endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleIndicators<?php echo $count; ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleIndicators<?php echo $count++; ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-10 col-lg-11 align-self-center ms-auto">
                            <!--TODO hashtag-->
                            <p class="lh-sm">
                                <?php echo $post['description'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-2 offset-2">
                            <a href="itinerary.php?itinerary_id=<?php echo $post['itinerary_id']; ?>"
                                class="btn text-muted p-0">
                                <i class="fa fa-map-o"></i>
                            </a>
                        </div>
                        <div class="col-2 text-center">
                            <a href="comment.php?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                                <i class="fa fa-comment-o"></i>
                                <?php $comments = getCommentCount($post['id']);
                                echo $comments; ?>
                            </a>
                        </div>
                        <div class="col-2 text-center">
                            <!--TODO with js-->
                            <a href="../Controller/postLikeController.php?post_id=<?php echo $post['id']; ?>"
                                class="btn text-muted p-0">
                                <i class="fa fa-heart-o"></i>
                                <?php $likes = getLikeCount($post['id']);
                                echo $likes; ?>
                            </a>
                        </div>
                        <div class="col-2 text-center">
                            <!--TODO with js-->
                            <a href="../Controller/postFavouriteController.php?post_id=<?php echo $post['id']; ?>"
                                class="btn text-muted p-0">
                                <i class="fa fa-star-o"></i>
                                <?php $favorites = getFavouriteCount($post['id']);
                                echo $favorites; ?>
                            </a>
                        </div>
                        <div class="col-2 text-end">
                            <!--TODO-->
                            <a href="#" class="btn text-muted p-0 px-3"><i class="fa fa-share"></i></a>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>

                <!--TODO Only for TEST logout button-->
                <div class="row mb-5">
                    <a href="../logout.php" class="btn btn-danger">Logout</a>
                </div>

            </div>
        </div>
        <nav class="navbar bg-light fixed-bottom border-top border-2">
            <div class="container">
                <div class="d-flex justify-content-around w-100 fs-3">
                    <a href="#" class="text-center text-dark"><i class="fa fa-home"></i></a>
                    <a href="#" class="text-center text-muted"><i class="fa fa-search"></i></a>
                    <a href="addPost.php" class="text-center text-muted"><i class="fa fa-plus"></i></a>
                    <a href="#" class="text-center text-muted"><i class="fa fa-bell-o"></i></a>
                    <a href="#" class="text-center text-muted"><i class="fa fa-envelope-o"></i></a>
                </div>
            </div>
        </nav>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    </body>

</html>