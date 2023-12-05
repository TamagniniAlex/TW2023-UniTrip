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

    <title>UniTrip</title>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <?php require_once("../Controller/commentController.php"); ?>
            <h1 class="text-center mb-4">UniTrip</h1>
            <div class="row mb-5 mt-3">
                <div class="col-2 col-lg-1 text-center">
                    <a href="<?php echo "profile.php?nickname=" . $post['nickname']; ?>">
                        <img src=<?php echo $post['photo_url']; ?> alt="Account Image" class="img-fluid rounded-circle">
                    </a>                
                </div>
                <div class="col-7 col-lg-9 align-self-center">
                    <a href="<?php echo "profile.php?nickname=" . $post['nickname']; ?>" class="btn p-0"><?php echo $post['name'];
                        echo " "; echo $post['surname'] ?>
                    </a>
                    <a href="<?php echo "profile.php?nickname=" . $post['nickname']; ?>" class="btn text-muted p-0">@<?php echo $post['nickname'] ?></a>
                    <a class="btn disabled text-muted p-0 px-3">&#9679 <?php echo $post['datetime'] ?></a>
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
            <div class="col-12 col-lg-9 px-5">
                <h5><?php echo $post['title'] ?></h5>
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
                <!--TODO hastag sarebbe bello fare una tabella nel db che conta quante volte viene usato un hastag-->
                <p class="lh-sm"> <?php echo $post['description'] ?> </p>
            </div>
            <hr>
            
            <!--Dynamic Posts-->
            <?php foreach ($comments as $comment) : ?>
            <div class="row">
                <div class="col-2 col-lg-1 text-center">
                    <a href="<?php echo "profile.php?nickname=" . $comment['nickname']; ?>">
                        <img src=<?php echo $comment['photo_url']; ?> alt="Account Image" class="img-fluid rounded-circle">
                    </a>                
                </div>
                <div class="col-10 col-lg-11 align-self-center">
                    <a href="<?php echo "profile.php?nickname=" . $comment['nickname']; ?>" class="btn p-0 fw-bold">
                        <?php echo $comment['name'] . " " . $comment['surname'] ?>
                    </a>
                    <a href="<?php echo "profile.php?nickname=" . $comment['nickname']; ?>" class="btn text-muted p-0">@<?php echo $comment['nickname'] ?></a>
                    <a class="btn disabled text-muted p-0 px-3">&#9679 <?php echo $comment['datetime'] ?></a>
                    <p class="lh-sm"><?php echo $comment['comment'] ?></p>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if (isset($_SESSION["nickname"])): ?>
    <div class="fixed-bottom m-3">
        <div class="d-flex justify-content-around w-100 fs-3 input-group">
            <input type="text" placeholder="Inserisci un commento" class="form-control" aria-label="User comment" aria-describedby="User comment">
            <button class="btn btn-outline-secondary" type="button" id="User comment">Invia</button>
        </div>
    </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>