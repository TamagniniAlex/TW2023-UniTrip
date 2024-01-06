$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const itinerary_id = urlParams.get('itinerary_id')
    if (itinerary_id != null && itinerary_id != "") {
        url = '../Controller/getItineraryController.php?itinerary_id=' + itinerary_id;
    } else {
        window.location.href = "../View/feed.html";
    }
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function (data) {
            if (data === "error") {
                window.location.href = "../View/feed.html";
            } else {
                $("#itineraryTitle").append(`<h2 class="text-center">` + data.name + " " + data.surname + " "
                    + data.organizer_username + `</h2>` + `<h3 class="text-center">` + data.description + `</h3>`);

                let oldDate = null;
                let currentTable = null;
                for (let i = 0; i < data.cities.length; i++) {
                    let city = data.cities[i];

                    let departureDateTime = new Date(city.departure_time);
                    let arrivalDateTime = new Date(city.arrival_time);

                    let departureTimeFormatted = departureDateTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    let arrivalTimeFormatted = arrivalDateTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    if (oldDate === null || oldDate.toDateString() !== departureDateTime.toDateString()) {
                        if (currentTable !== null) {
                            $("#itinerary").append('</table>');
                        }

                        $("#itinerary").append('<h4 class="text-center">' + departureDateTime.toLocaleDateString('it-IT') + '</h4>');

                        $("#itinerary").append(`
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Partenza</th>
                                        <th>Orario</th>
                                        <th>Arrivo</th>
                                        <th>Orario</th>
                                    </tr>
                                </thead>
                                <tbody>   
                        `);

                        oldDate = departureDateTime;
                        currentTable = $("#itinerary table:last");
                    }

                    let row = '<tr><td>' + city.departure_city + '</td><td>' + departureTimeFormatted + '</td><td>' +
                        city.arrival_city + '</td><td>' + arrivalTimeFormatted + '</td></tr>';
                    currentTable.find('tbody').append(row);
                }

                if (currentTable !== null) {
                    $("#itinerary").append('</table>');
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
});