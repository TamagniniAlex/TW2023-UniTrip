<?php
require_once("../model/itineraryModel.php");

$itinerary = new ItineraryModel();

if (isset($_GET["itinerary_id"]) && !empty($_GET["itinerary_id"])) {
    echo json_encode($itinerary->getItineraryInformation($_GET["itinerary_id"]));
} else {
    echo json_encode("error");
}

?>