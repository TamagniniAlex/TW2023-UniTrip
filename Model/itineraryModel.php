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
        return $this->db->getItineraryInformation($itinerary_id);
    }
    public function getItineraryBetweenCities($itinerary_id)
    {
        return $this->db->getItineraryBetweenCities($itinerary_id);
    }
}

?>