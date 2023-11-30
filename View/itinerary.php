<!doctype html>
<html lang="it">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Stile Personalizzato -->
    <link rel="stylesheet" href="style.css">

    <title>UniTrip</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php require_once("../Controller/itineraryController.php"); ?>
                <div>
                    <h1 class="text-center">Itinerario</h1>
                    <h2 class="text-center"><?php echo $itinerary_information["name"] . " " . $itinerary_information["surname"] . " " . $itinerary_information["organizer_username"] ?></h2>
                    <h3 class="text-center"><?php echo $itinerary_information["description"] ?></h3>
                </div>
                <hr>
                <div>
                    <h3 class="text-center">Itinerario tra città</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Partenza</th>
                                <th scope="col">Ora Partenza</th>
                                <th scope="col">Arrivo</th>
                                <th scope="col">Ora Arrivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($itinerary_between_cities as $itinerary_between_city) { ?>
                            <tr>
                                <td><?php echo $itinerary_between_city["departure_city"] ?></td>
                                <td><?php echo $itinerary_between_city["departure_time"] ?></td>
                                <td><?php echo $itinerary_between_city["arrival_city"] ?></td>
                                <td><?php echo $itinerary_between_city["arrival_time"] ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>