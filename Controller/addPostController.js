$(document).ready(function () {
    var selectNations = $('#selectNations');
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
        getCities(selectNations);
    });
});

var stageCount = 1;

function addStage() {
    var newStageHTML = `
        <div class="row mb-4">
            <div class="col-8 p-0">
                <select id="selectCities${stageCount}" class="form-select" aria-label="Seleziona città di partenza">
                    <option selected disabled>Seleziona città di partenza</option>
                </select>
            </div>
            <div class="col-4 p-0">
                <input type="time" class="form-control" id="departureTime${stageCount}" name="departureTime">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-8 p-0">
                <select id="selectCities${stageCount + 1}" class="form-select" aria-label="Seleziona città di arrivo">
                    <option selected disabled>Seleziona città di arrivo</option>
                </select>
            </div>
            <div class="col-4 p-0">
                <input type="time" class="form-control" id="arrivalTime${stageCount}" name="arrivalTime">
            </div>
        </div>
        <hr class="row mb-4">
    `;

    var lastHr = document.querySelectorAll('hr')[document.querySelectorAll('hr').length - 1];
    lastHr.insertAdjacentHTML('afterend', newStageHTML);
    stageCount += 2;

    var selectNations = $('#selectNations');
    console.log(selectNations.val());
    getCities(selectNations)
}

function getCities(selectNations) {
    var selectedNation = $(selectNations).val();
    for (var i = 1; i <= stageCount; i++) {
        var selectCities = $('#selectCities' + i);
        selectCities.empty();
        selectCities.append('<option value="" disabled selected>Seleziona città</option>');
    }
    $.ajax({
        type: 'GET',
        url: '../Controller/getCitiesController.php',
        data: { nation: selectedNation },
        dataType: 'json',
        success: function (cities) {
            cities.forEach(function (city) {
                for (var i = 1; i <= stageCount; i++) {
                    var selectCities = $('#selectCities' + i);
                    selectCities.append('<option value="' + city.name + '">' + city.name + '</option>');
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}