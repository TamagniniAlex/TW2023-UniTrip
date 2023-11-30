<!doctype html>
<html lang="it">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--TODO Stile Personalizzato -->
    <link rel="stylesheet" href="style.css">

    <title>Feed</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <?php require_once("../Controller/feedController.php"); ?>
            <h1 class="text-center mb-4">UniTrip</h1>
            <div class="row mb-4">
                <div class="col-2 col-lg-1 text-center">
                    <a href=<?php echo "profile.html?nickname=" . $_SESSION["nickname"]; ?>>
                        <img src=<?php echo $photo_url; ?> alt="Account Image" class="img-fluid rounded-circle">
                    </a>
                </div>
                <div class="col-4 col-lg-5 align-self-center text-end">
                    <!--TODO-->
                    <a href="#" class="btn">Suggeriti</a>
                </div>
                <div class="col-4 col-lg-5 align-self-center text-justify">
                    <!--TODO-->
                    <a href="#" class="btn active">Seguiti</a>
                </div>
                <div class="col-2 col-lg-1 align-self-center text-center fs-3">
                    <!--TODO-->
                    <a href="#" class="text-dark"><i class="fa fa-star-o"></i></a>
                </div>
            </div>
            <hr>

            <!--Dynamic Posts-->
            <?php foreach ($posts as $post) : ?>
                <div class="row mb-2">
                    <div class="col-2 col-lg-1 text-center">
                        <a href="<?php echo "profile.html?nickname=" . $post['nickname']; ?>">
                            <img src=<?php echo $post['photo_url']; ?> alt="Account Image" class="img-fluid rounded-circle">
                        </a>
                    </div>
                    <div class="col-7 col-lg-9 align-self-center">
                        <a href="<?php echo "profile.html?nickname=" . $post['nickname']; ?>" class="btn p-0"><?php echo $post['name'] . " " . $post['surname'] ?>
                        </a>
                        <a href="<?php echo "profile.html?nickname=" . $post['nickname']; ?>" class="btn text-muted p-0">@<?php echo $post['nickname'] ?></a>
                        <a class="btn disabled text-muted p-0 px-3">&#9679 <?php echo $post['datetime'] ?></a>
                    </div>
                    <!--TODO non in questa pagina
                    <div class="col-3 col-lg-2 align-self-center text-center">
                        <button type="submit" class="btn btn-secondary form-control">Segui</button>
                    </div>
                    -->
                </div>
                <div class="row mb-2">
                    <div class="col-10 col-lg-11 align-self-center ms-auto">
                        <h5><?php echo $post['title'] ?></h5>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-10 col-lg-11 align-self-center ms-auto">
                        <!--TODO-->
                        <img src="../img/black.jpg" alt="Account Image" class="img-fluid rounded">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-10 col-lg-11 align-self-center ms-auto">
                        <!--TODO hashtag-->
                        <p class="lh-sm"><?php echo $post['description'] ?></p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-2 offset-2">
                        <a href="itinerary.php?itinerary_id=<?php echo $post['itinerary_id']; ?>" class="btn text-muted p-0">
                            <i class="fa fa-map-o"></i>
                        </a>
                    </div>
                    <div class="col-2 text-center">
                        <a href="comment.php?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                            <i class="fa fa-comment-o"></i>
                            <!--TODO MORETTI, STAI CHIAMANDO IL MODEL DALLA VIEW?!?!?!?!?-->
                            <?php $comments = $feed->db->getCommentCount($post['id']); echo $comments; ?>
                        </a>
                    </div>
                    <div class="col-2 text-center">
                        <!--TODO with js-->
                        <a href="../Controller/postLikeController.php?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                            <!--TODO MORETTI, STAI CHIAMANDO IL MODEL DALLA VIEW?!?!?!?!?-->
                            <i class="fa fa-heart-o"></i> <?php $likes = $feed->db->getLikeCount($post['id']); echo $likes; ?>
                        </a>
                    </div>
                    <div class="col-2 text-center">
                        <!--TODO with js-->
                        <a href="../Controller/postFavouriteController.php?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                            <!--TODO MORETTI, STAI CHIAMANDO IL MODEL DALLA VIEW?!?!?!?!?-->
                            <i class="fa fa-star-o"></i> <?php $favorites = $feed->db->getFavouriteCount($post['id']); echo $favorites; ?>
                        </a>
                    </div>
                    <div class="col-2 text-end">
                        <!--TODO-->
                        <a href="#" class="btn text-muted p-0 px-3"><i class="fa fa-share"></i></a>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>