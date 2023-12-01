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

    <!-- Stile Personalizzato -->
    <link rel="stylesheet" href="style.css">

    <title>UniTrip</title>
</head>

<body>
    <div class="container mt-5">
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
                <!--TODO non in questa pagina
                <div class="col-3 col-lg-2 align-self-center text-center">
                    <button type="submit" class="btn btn-secondary form-control">Segui</button>
                </div>
                -->
            </div>
            <div class="col-12 col-lg-9 px-5">
                <h5><?php echo $post['title'] ?></h5>
                <!--TODO-->
                <img src="../img/black.jpg" alt="Account Image" class="img-fluid rounded mb-2 mt-2">
                <!--TODO hastag-->
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
                    <a href="<?php echo "profile.php?nickname=" . $comment['nickname']; ?>" class="btn p-0"><?php echo $comment['name'];
                        echo " "; echo $comment['surname'] ?>
                    </a>
                    <a href="<?php echo "profile.php?nickname=" . $comment['nickname']; ?>" class="btn text-muted p-0">@<?php echo $comment['nickname'] ?></a>
                    <a class="btn disabled text-muted p-0 px-3">&#9679 <?php echo $comment['datetime'] ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-10 offset-2 col-lg-11 offset-lg-1 align-self-center">
                    <p class="lh-sm"><?php echo $comment['comment'] ?></p>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>