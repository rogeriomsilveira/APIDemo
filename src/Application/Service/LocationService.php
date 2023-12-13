<?php

namespace Application\Service;

use Helper\Response\Header;
use Application\Repository\LocationRepository;

/* ------------------------------------------------------------------------------------------------- */

class LocationService
{
    private $locationRepository;
    private $header;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->header = new Header();
    }

    /* ================================================================================================= */

    public function readAllLocations($userId)
    {
        return $this->locationRepository->readAllLocations($userId);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readLastLocation($userId)
    {
        return $this->locationRepository->readLastLocation($userId);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createLocation($payload) {
        $this->validateDataEntry($payload);
        $this->locationRepository->createLocation($payload);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteAllLocations($userId) {
        $this->locationRepository->deleteAllLocations($userId);
    }

    /* =================================================================================================

        Validations of business rules must be done here.
        Also, if the data must be modified in some way (changing case, encoding password, etc),
        that should be done here too.

       ================================================================================================= */

    private function validateDataEntry($payload) {

        $validKeys = array('user_id', 'latitude', 'longitude');

        foreach($validKeys as $key => $value) {
            if (array_key_exists($key, $payload)) {
                if ($key == 'user_id' && !is_numeric($value)) {
                    $this->header->response('error', 'validation', array('code'=>2660, 'message'=>"userId is invalid. It must be numeric."));
                }
                if ($key == 'latitude' && (!is_numeric($value) || $value < -90 || $value > 90)) {
                    $this->header->response('error', 'validation', array('code'=>2670, 'message'=>"Latitude is invalid. It must be between -90 and 90."));
                } 
                if ($key == 'latitude' && (!is_numeric($value) || $value < -180 || $value > 180)) {
                    $this->header->response('error', 'validation', array('code'=>2680, 'message'=>"Latitude is invalid. It must be between -180 and 180."));
                }
            }
        }
    }

    /* ================================================================================================= */

}