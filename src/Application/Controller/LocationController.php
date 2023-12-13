<?php

namespace Application\Controller;

use Helper\Response\Header;
use Helper\Request\Loader;
use Helper\Request\Validator;
use Application\Service\LocationService;

/* ------------------------------------------------------------------------------------------------- */

class LocationController
{
    private $locationService;
    private $header;
    private $loader;
    private $validator;

    /* ------------------------------------------------------------------------------------------------- */

    public function __construct(LocationService $locationService)
    {
        $this->loader = new Loader();

        $validKeys = array('user_id', 'latitude', 'longitude');
        $this->validator = new Validator($validKeys);

        $this->header = new Header();
        $this->locationService = $locationService;
    }

    /* ================================================================================================= */

    public function readAllLocations($userId)
    {
        $location = $this->locationService->readAllLocations($userId);
        $this->header->response('success', 'get', $location);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function readLastLocation($userId)
    {
        $location = $this->locationService->readLastLocation($userId);
        $this->header->response('success', 'get', $location);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function createLocation() {
        $payload = $this->loader->parseRequest();
        $this->validator->validatePostRequest($payload);
        $this->locationService->createLocation($payload);
    }

    /* ------------------------------------------------------------------------------------------------- */

    public function deleteAllLocations($userId) {
        $this->locationService->deleteAllLocations($userId);
    }

    /* ================================================================================================= */

}