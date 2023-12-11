$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const itinerary_id = urlParams.get('itinerary_id')
    if (itinerary_id != null && itinerary_id != "") {
        url = '../Controller/getItineraryController.php?itinerary_id=' + itinerary_id;
    } else {
        window.location.replace("../View/feed.html");
    }
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function (data) {
            $("#itineraryTitle").append(`<h2 class="text-center">` + data.name + " " + data.surname + " "
                + data.organizer_username + `</h2>` + `<h3 class="text-center">` + data.description + `</h3>`);

            var tableBody = $('#itineraryBodyTable');
            tableBody.empty(); // Svuota il corpo della tabella

            for (var i = 0; i < data.cities.length; i++) {
                var city = data.cities[i];
                var row = '<tr>' +
                    '<td>' + city.departure_city + '</td>' +
                    '<td>' + city.departure_time + '</td>' +
                    '<td>' + city.arrival_city + '</td>' +
                    '<td>' + city.arrival_time + '</td>' +
                    '</tr>';
                tableBody.append(row);
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
});