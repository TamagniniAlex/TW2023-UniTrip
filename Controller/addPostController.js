$(document).ready(function () {
    var selectNations = $('#selectNations');
    var selectCities = $('#selectCities');

    // Prende le nazioni
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

    // Quando cambia la nazione selezionata
    selectNations.change(function () {
        var selectedNation = $(this).val();

        selectCities.empty();
        selectCities.append('<option value="" disabled selected>Seleziona città</option>');

        // Prende le città della nazione selezionata
        $.ajax({
            type: 'GET',
            url: '../Controller/getCitiesController.php',
            data: { nation: selectedNation },
            dataType: 'json',
            success: function (cities) {
                cities.forEach(function (city) {
                    selectCities.append('<option value="' + city.name + '">' + city.name + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error('Errore nella richiesta AJAX:', status, error);
            }
        });
    });
});

var stageCount = 1;

function addStage() {
    var newStageHTML = `
        <div class="row mb-4">
            <select id="selectCities${stageCount}" class="form-select" aria-label="Seleziona città di partenza">
                <option selected disabled>Seleziona città di partenza</option>
            </select>
        </div>
        <div class="row mb-4">
            <input type="time" class="form-control" id="departureTime${stageCount}" name="departureTime">
        </div>
        <div class="row mb-4">
            <select id="selectCities${stageCount + 1}" class="form-select" aria-label="Seleziona città di arrivo">
                <option selected disabled>Seleziona città di arrivo</option>
            </select>
        </div>
        <div class="row mb-4">
            <input type="time" class="form-control" id="arrivalTime${stageCount}" name="arrivalTime">
        </div>
        <hr class="row mb-4">
    `;

    var lastHr = document.querySelectorAll('hr')[document.querySelectorAll('hr').length - 1];

    var wrapper = document.createElement('div');
    wrapper.innerHTML = newStageHTML;

    lastHr.parentNode.insertBefore(wrapper, lastHr.nextSibling);

    stageCount += 2;
}