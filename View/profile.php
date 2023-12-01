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

    <!-- Stile Personalizzato -->
    <link rel="stylesheet" href="style.css">

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
                <!--TODO da capire-->
                <div class="col-3 col-lg-2 offset-7 offset-lg-9 align-self-center text-center">
                    <button type="submit" class="btn btn-secondary form-control">Modifica</button>
                </div>
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
            <div class="row mb-4 text-center">
                <!--TODO-->
                <div class="col-4">
                    <a class="btn"><strong>Posts</strong></a>
                </div>
                <!--TODO-->
                <div class="col-4">
                    <a class="btn">Mi piace</a>
                </div>
                <!--TODO-->
                <div class="col-4">
                    <a class="btn">Preferiti</a>
                </div>
            </div>
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
                            <a href="comment.php?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                                <i class="fa fa-comment-o"></i>
                                <!--TODO MORETTI, STAI CHIAMANDO IL MODEL DALLA VIEW?!?!?!?!?-->
                                <?php $comments = $profile->db->getCommentCount($post['id']); echo $comments; ?>
                            </a>                        
                        </div>
                        <div class="col-4 text-center p-0">
                            <!--TODO with js, quando meti like torna ad una pagina sbagliata-->
                            <a href="../Controller/postLikeController.php?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                                <!--TODO MORETTI, STAI CHIAMANDO IL MODEL DALLA VIEW?!?!?!?!?-->
                                <i class="fa fa-heart-o"></i> <?php $likes = $profile->db->getLikeCount($post['id']); echo $likes; ?>
                            </a>                        
                        </div>
                        <div class="col-3 text-start p-0">
                            <!--TODO with js, quando meti star torna ad una pagina sbagliata-->
                            <a href="../Controller/postFavouriteController.php?post_id=<?php echo $post['id']; ?>" class="btn text-muted p-0">
                                <!--TODO MORETTI, STAI CHIAMANDO IL MODEL DALLA VIEW?!?!?!?!?-->
                                <i class="fa fa-star-o"></i> <?php $favorites = $profile->db->getFavouriteCount($post['id']); echo $favorites; ?>
                            </a>                        
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