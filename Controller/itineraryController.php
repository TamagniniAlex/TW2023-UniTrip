<?php
require_once("../model/itineraryModel.php");

$itinerary = new ItineraryModel();

if (isset($_GET["itinerary_id"]) && !empty($_GET["itinerary_id"])) {
    $itinerary_id = $_GET["itinerary_id"];
    $itinerary_information = $itinerary->getItineraryInformation($itinerary_id);
    $itinerary_between_cities = $itinerary->getItineraryBetweenCities($itinerary_id);
} else {
    header("Location: ../view/feed.html");
}

?>