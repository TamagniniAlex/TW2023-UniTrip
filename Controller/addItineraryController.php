<?php
require_once("../model/itineraryModel.php");

$itinerary = new ItineraryModel();

if ($_SESSION["nickname"] && $_POST["itinerary_description"]) {
    echo json_encode($itinerary->addItinerary($_SESSION["nickname"], $_POST["itinerary_description"], $_POST["itinerary_between_cities"]));
} else {
    echo json_encode("error");
}

?>