<?php
require_once("../libraries/Model.php");

class ItineraryModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getItineraryInformation($itinerary_id)
    {
        $itinerary = $this->db->getItineraryInformation($itinerary_id);
        if (!empty($itinerary)) {
            $itinerary["cities"] = $this->db->getItineraryBetweenCities($itinerary_id);
            return $itinerary;
        }
        return "error";
    }
    public function addItinerary($nickname, $itinerary_description, $itinerary_between_cities)
    {
        $itinerary_id = $this->db->addItinerary($nickname, $itinerary_description);
        if ($itinerary_id) {
            for ($i = 0; $i < count($itinerary_between_cities); $i++) {
                $this->db->addItineraryBetweenCities($itinerary_id, $itinerary_between_cities[$i][0], $itinerary_between_cities[$i][1],
                    $itinerary_between_cities[$i][2], $itinerary_between_cities[$i][3]);
            }
            return $itinerary_id;
        }
        return "error";
    }
}

?>