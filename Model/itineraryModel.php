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
}

?>