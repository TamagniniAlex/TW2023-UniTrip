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

        <!--TODO Stile Personalizzato -->
        <link rel="stylesheet" href="style.css">

        <!--TODO Script Personalizzato -->
        <script src="../script.js"></script>

        <title>Add post</title>
    </head>

    <body>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <?php require_once("../Controller/addPostController.php"); ?>
                <h1 class="text-center mb-4">Aggiungi post</h1>
                <div class="row mb-4 col-10">
                    <select class="form-select" aria-label="Seleziona nazione">
                        <option selected disabled>Seleziona nazione</option>
                    </select>
                </div>
                <div class="row mb-4 col-10">
                    <select class="form-select" aria-label="Seleziona città">
                        <option selected disabled>Seleziona città</option>
                    </select>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    </body>

</html>