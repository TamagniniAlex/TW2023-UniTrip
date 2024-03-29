$(document).ready(function () {
    let selectNations = $('#selectNations');
    $.ajax({
        type: 'GET',
        url: '../Controller/getCountryController.php',
        dataType: 'json',
        success: function (nations) {
            if (nations === "error") {
                window.location.href = "../View/index.html";
            } else {
                nations.forEach(function (nation) {
                    selectNations.append('<option value="' + nation.name + '">' + nation.name + '</option>');
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
    selectNations.change(function () {
        getCities(selectNations, true);
    });
});

let stageCount = 1;

function addStage() {
    let newStageHTML = `
        <div class="row mb-5">
            <div class="col-12 p-0 mb-2">
                <label for="selectCities${stageCount}" class="form-label">Seleziona città di partenza:</label>
                <select id="selectCities${stageCount}" class="form-select" aria-label="Seleziona città di partenza">
                    <option selected disabled>Seleziona città di partenza</option>
                </select>
            </div>
            <div class="col-4 p-0 offset-1">
                <label for="departureDate${stageCount}" class="form-label">Data di partenza:</label>
                <input type="date" class="form-control" id="departureDate${stageCount}" name="departureDate">
            </div>
            <div class="col-4 p-0 offset-2">
                <label for="departureTime${stageCount}" class="form-label">Ora di partenza:</label>
                <input type="time" class="form-control" id="departureTime${stageCount}" name="departureTime">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 p-0 mb-2">
                <label for="selectCities${stageCount + 1}" class="form-label">Seleziona città di arrivo:</label>
                <select id="selectCities${stageCount + 1}" class="form-select" aria-label="Seleziona città di arrivo">
                    <option selected disabled>Seleziona città di arrivo</option>
                </select>
            </div>
            <div class="col-4 p-0 offset-1">
                <label for="arrivalDate${stageCount}" class="form-label">Data di arrivo:</label>
                <input type="date" class="form-control" id="arrivalDate${stageCount}" name="departureDate">
            </div>
            <div class="col-4 p-0 offset-2">      
                <label for="arrivalTime${stageCount}" class="form-label">Ora di arrivo:</label>            
                <input type="time" class="form-control" id="arrivalTime${stageCount}" name="arrivalTime">
            </div>
        </div>
        <hr class="row mb-4">
    `;

    let lastHr = document.querySelectorAll('hr')[document.querySelectorAll('hr').length - 1];
    lastHr.insertAdjacentHTML('afterend', newStageHTML);
    stageCount += 2;

    let selectNations = $('#selectNations');
    getCities(selectNations, false)
}

function getCities(selectNations, reload) {
    let selectedNation = $(selectNations).val();
    if (selectedNation !== null) {
        for (let i = 1; i <= stageCount; i++) {
            if ($('#selectCities' + i).val == null || reload) {
                $('#selectCities' + i).empty().append('<option value="" disabled selected>' +
                    (i % 2 === 0 ? 'Seleziona città di arrivo' : 'Seleziona città di partenza') + '</option>');
            }
        }
        $.ajax({
            type: 'GET',
            url: '../Controller/getCitiesController.php',
            data: { nation: selectedNation },
            dataType: 'json',
            success: function (cities) {
                for (let i = 1; i <= stageCount; i++) {
                    let selectCities = $('#selectCities' + i);
                    if (selectCities.children().length != cities.length + 1) {
                        for (let j = 0; j < cities.length; j++) {
                            selectCities.append('<option value="' + cities[j].name + '">' + cities[j].name + '</option>');
                        }
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Errore nella richiesta AJAX:', status, error);
            }
        });
    }
}

function addPost() {
    let title = $('#title').val();
    let description = $('#description').val();
    let nation = $('#selectNations').val();
    let photos = $('#multipleImage')[0];
    let itineraryDescription = $('#itineraryDescription').val();
    let itineraryBetweenCities = [];
    if (stageCount > 1 && title !== null && description !== null && nation !== null && itineraryDescription !== null && photos.files.length > 0) {
        for (let i = 1; i < stageCount; i += 2) {
            let departureCity = $('#selectCities' + i).val();
            let departureDate = $('#departureDate' + i).val();
            let departureTime = $('#departureTime' + i).val();
            let arrivalCity = $('#selectCities' + (i + 1)).val();
            let arrivalDate = $('#arrivalDate' + i).val();
            let arrivalTime = $('#arrivalTime' + i).val();
            if (departureCity !== null && departureTime !== null && arrivalCity !== null && arrivalTime !== null && departureDate !== null && arrivalDate !== null) {
                let itinerarySegment = [departureCity, departureDate + " " + departureTime, arrivalCity, arrivalDate + " " + arrivalTime];
                itineraryBetweenCities.push(itinerarySegment);
            } else {
                return;
            }
        }
        $.ajax({
            type: 'POST',
            url: '../Controller/addItineraryController.php',
            data: { itinerary_description: itineraryDescription, itinerary_between_cities: itineraryBetweenCities },
            dataType: 'json',
            success: function (response) {
                if (response !== "error") {
                    $.ajax({
                        type: 'POST',
                        url: '../Controller/addPostController.php',
                        data: { title: title, description: description, country: nation, itinerary_id: response },
                        dataType: 'json',
                        success: function (response) {
                            if (response !== "error") {
                                let post_id = response;
                                let files = photos.files;
                                let formData = new FormData();
                                for (let i = 0; i < files.length; i++) {
                                    formData.append('file[]', files[i]);
                                }
                                $.ajax({
                                    type: 'POST',
                                    url: '../Controller/uploadPhotoController.php?post_id=' + post_id,
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) {
                                        if (response !== "error") {
                                            let photos_url = JSON.parse(response);
                                            $.ajax({
                                                type: 'POST',
                                                url: '../Controller/addPostPhotoController.php',
                                                data: { post_id: post_id, photos_url: photos_url },
                                                dataType: 'json',
                                                success: function (response) {
                                                    if (response === "success") {
                                                        window.location.href = "../View/comment.html?post_id=" + post_id;
                                                    } else {
                                                        return;
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error('Errore nella richiesta AJAX:', status, error);
                                                }
                                            });
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('Errore nella richiesta AJAX:', status, error);
                                    }
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Errore nella richiesta AJAX:', status, error);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Errore nella richiesta AJAX:', status, error);
            }
        });
    } else {
        return;
    }
}