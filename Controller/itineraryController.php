<?php
require_once("../model/itineraryModel.php");

$itinerary = new ItineraryModel();

if (isset($_GET["itinerary_id"])) {
    $itinerary_id = $_GET["itinerary_id"];
    $itinerary_information = $itinerary->getItineraryInformation($itinerary_id);
    $itinerary_between_cities = $itinerary->getItineraryBetweenCities($itinerary_id);
} else {
    //TODO remove it
    echo json_encode(array("error" => "itinerary_id not set"));
}

?>