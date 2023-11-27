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

    <title>Feed</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <h1 class="text-center mb-4">UniTrip</h1>
            <div class="row mb-4">
                <div class="col-2 col-lg-1 text-center">
                    <a href="#"><img src="img/profile/gray.jpg" alt="Account Image" class="img-fluid rounded-circle"></a>
                </div>
                <div class="col-4 col-lg-5 align-self-center text-end">
                    <a href="#" class="btn">Suggeriti</a>
                </div>
                <div class="col-4 col-lg-5 align-self-center text-justify">
                    <a href="#" class="btn">Seguiti</a>
                </div>
                <div class="col-2 col-lg-1 align-self-center text-center fs-3">
                    <a href="#" class="text-dark"><i class="fa fa-star-o"></i></a>
                </div>
            </div>
            <hr>
            <!--Post 1-->
            
            <?php require_once("feed-follower.php") ?>
            <?php foreach($posts as $post): ?>
            <div class="row mb-3">
                <div class="col-2 col-lg-1 text-center">
                    <a href="#"><img src="img/profile/gray.jpg" alt="Account Image" class="img-fluid rounded-circle"></a>
                </div>
                <div class="col-7 col-lg-9 align-self-center">
                    <a href="#" class="btn text-muted p-0"><?php echo $post['author']?></a>
                    <a href="#" class="btn text-muted p-0">@riccardo_il_moro</a>
                    <a class="btn disabled text-muted p-0 px-3">&#9679 1d</a>
                </div>
                <div class="col-3 col-lg-2 align-self-center text-center">
                    <button type="submit" class="btn btn-secondary form-control">Segui</button>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-10 col-lg-11 align-self-center ms-auto">
                    <img src="img/black.jpg" alt="Account Image" class="img-fluid rounded">
                </div>
            </div>
            <?php endforeach; ?>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>