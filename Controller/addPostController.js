$(document).ready(function () {
    var selectNations = $('#selectNations');
    var selectCities = $('#selectCities');

    // Prende le nazioni
    $.ajax({
        type: 'GET',
        url: '../Controller/getCountryController.php',
        dataType: 'json',
        success: function (nations) {
            nations.forEach(function (nation) {
                selectNations.append('<option value="' + nation.name + '">' + nation.name + '</option>');
            });
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